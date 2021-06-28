import base64
import io
import json
from time import sleep

import flask
import matplotlib
import numpy as np
import seaborn as sns
from celery import Celery
from matplotlib import pyplot as plt, animation
from flask import Flask, send_file, render_template, request, jsonify, make_response
from pymongo import MongoClient

from covid_simulation.Status import Status
from covid_simulation.constantes import SimulationData
from covid_simulation.database_adapter import DatabaseAdapter
from covid_simulation.graph_plot import GraphPlot
from covid_simulation.message_broker_adapter import MessageBrokerAdapter
from covid_simulation.simulation_data import Simulation
from flask_cors import CORS

# todo create route from js to flask + add to mongo result + create simulation html file
from covid_simulation.simulation_result_persistence import SimulationPersistence


def add_simulation_worker(DURATION, DENSITY, confinement, port_du_mask, border, new_variant):
    global constantes
    global simulation
    database_adapter = DatabaseAdapter(collection)
    simulation_persistence = SimulationPersistence(database_adapter)
    constantes = SimulationData(DURATION, DENSITY, confinement, port_du_mask, border, new_variant)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    people = simulation.create_data()
    simulation.update_graph(people)
    id = simulation_persistence.insert_one_simulation(Status.CREATED, DURATION, DENSITY, confinement, port_du_mask,
                                                      border, new_variant, [], [])
    message_brocker.send_async([id, DURATION, DENSITY, confinement, port_du_mask,
                                border, new_variant, [], []], 'result_simulation', 'simulation')


def set_up(DURATION, DENSITY, confinement, port_du_mask, border, new_variant):
    global constantes
    global simulation
    constantes = SimulationData(DURATION, DENSITY, confinement, port_du_mask, border, new_variant)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    people = simulation.create_data()
    simulation.update_graph(people)

def set_up_by_id(id):
    global constantes
    global simulation
    simulation = simulation_persistence.find_one_simulation_by_id(id)
    constantes = SimulationData(simulation.DURATION, simulation.DENSITY, simulation.confinement, simulation.port_du_mask,
                                simulation.border, simulation.new_variant)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    people = simulation.create_data()
    simulation.update_graph(people)


app = Flask(__name__, static_folder='static')


@app.route('/set_simulation', methods=['GET', 'POST'])
def set_simulation():
    if request.method == 'POST':
        post_data = request.get_json()
        print(post_data)
        set_up(int(post_data.get('nombre_jours')), int(post_data.get('population')), bool(post_data.get('confinement')),
               bool(post_data.get('port_mask')),
               bool(post_data.get('deplacement_region')), int(post_data.get('new_variant')))

    response = make_response(json.dumps({'success': True}), 200, {'ContentType': 'application/json'})
    response.headers.add('Access-Control-Allow-Origin', '*')
    return response

@app.route('/set_simulation_id', methods=['GET', 'POST'])
def set_simulation_id():
    if request.method == 'POST':
        post_data = request.get_json()
        print(post_data)
        set_up_by_id(str(post_data.get('id')))
    response = make_response(json.dumps({'success': True}), 200, {'ContentType': 'application/json'})
    response.headers.add('Access-Control-Allow-Origin', '*')
    return response



@app.route('/add_simulation', methods=['GET', 'POST'])
def add_simulation():
    if request.method == 'POST':
        post_data = request.get_json()
        print(post_data)
        add_simulation_worker(int(post_data.get('nombre_jours')), int(post_data.get('population')), bool(post_data.get('confinement')),
               bool(post_data.get('port_mask')),
               bool(post_data.get('deplacement_region')), int(post_data.get('new_variant')))

    response = make_response(json.dumps({'success': True}), 200, {'ContentType': 'application/json'})
    response.headers.add('Access-Control-Allow-Origin', '*')
    return response

@app.route('/simulation', methods=['GET'])
def get_simulation():
    simulations = simulation_persistence.find_simulations()
    simulations = simulations[::-1]
    data = []
    for simulation in simulations:
        data.append({'id': simulation.get_id(), "duree": simulation.get_duration(), "population": simulation.get_density(),
                     "port_mask": simulation.get_port_du_mask(), "deplacement_region": simulation.get_border(),
                     "new_variant": simulation.get_new_variant(), "status": simulation.get_status()})
    response = make_response(jsonify(data), 200, {'ContentType': 'application/json'})
    print(response.data)
    response.headers.add('Access-Control-Allow-Origin', '*')
    return response

@app.route('/simulation_result/<id>', methods=['GET'])
def simulation_result(id):
    fig = plt.figure(1, figsize=(18, 8))
    result = simulation_persistence.find_one_simulation_by_id(str(id))
    print(result)
    constantes = SimulationData(result.DURATION, result.DENSITY, result.confinement, result.port_du_mask, result.border,
                                result.new_variant)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    simulation.plot_stats(result.infected_stats, result.dead_stats)

    img = io.BytesIO()
    sleep(1)
    plt.savefig(img, format='png')
    img.seek(0)
    plot_url = base64.b64encode(img.getvalue()).decode()

    return render_template('simulation_result.html', plot_url=plot_url)



@app.route('/simulation_direct', methods=['GET'])
def simulation_direct():
    fig = plt.figure(1, figsize=(18, 8))
    img = io.BytesIO()
    anim = animation.FuncAnimation(fig, simulation.next_loop_event, frames=np.arange(constantes.DURATION * 24),
                                   interval=100, repeat=False)
    sleep(1)
    plt.savefig(img, format='png')
    img.seek(0)
    plot_url = base64.b64encode(img.getvalue()).decode()

    return render_template('simulation_direct.html', plot_url=plot_url)


def test(id):
    result = simulation_persistence.find_one_simulation_by_id(id)
    constantes = SimulationData(result.DURATION, result.DENSITY, result.confinement, result.port_du_mask, result.border,
                                result.new_variant)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    simulation.plot_stats(result.infected_stats, result.dead_stats)


if __name__ == '__main__':
    client = MongoClient('localhost')
    database = client.get_database('simulation')
    collection = database.get_collection('result')
    celery_app = Celery('task', broker='redis://localhost:6379/0')
    database_adapter = DatabaseAdapter(collection)
    simulation_persistence = SimulationPersistence(database_adapter)
    message_brocker = MessageBrokerAdapter(celery_app)
    matplotlib.use('Agg')
    CORS(app)
    sns.set()
    fig = plt.figure(1, figsize=(18, 8))
    #test("60d886cf026e8f62d0415c4f")
    #plt.show()
    #add_simulation_worker(10, 900, False, False, False, 15)
    app.run(debug=True)
