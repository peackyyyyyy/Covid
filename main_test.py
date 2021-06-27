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
    database_adapter = DatabaseAdapter(collection)
    simulation_persistence = SimulationPersistence(database_adapter)
    constantes = SimulationData(DURATION, DENSITY, confinement, port_du_mask, border, new_variant)
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


@app.route('/direct', methods=['GET'])
def build_plot():
    fig = plt.figure(1, figsize=(30, 13))
    img = io.BytesIO()
    anim = animation.FuncAnimation(fig, simulation.next_loop_event, frames=np.arange(constantes.DURATION * 24),
                                   interval=100, repeat=False)
    sleep(1)
    plt.savefig(img, format='png')
    img.seek(0)
    plot_url = base64.b64encode(img.getvalue()).decode()

    return render_template('test.html', plot_url=plot_url)


if __name__ == '__main__':
    client = MongoClient('localhost')
    database = client.get_database('simulation')
    collection = database.get_collection('result')
    celery_app = Celery('task', broker='redis://localhost:6379/0')
    message_brocker = MessageBrokerAdapter(celery_app)
    matplotlib.use('Agg')
    CORS(app)
    sns.set()
    fig = plt.figure(1, figsize=(30, 13))
    #add_simulation_worker(10, 900, False, False, False, 15)
    app.run(debug=True)
