import base64
import io
from time import sleep

import flask
import matplotlib
import numpy as np
import seaborn as sns
from matplotlib import pyplot as plt, animation
from flask import Flask, send_file, render_template, request, jsonify, make_response
from covid_simulation.constantes import SimulationData
from covid_simulation.graph_plot import GraphPlot
from covid_simulation.simulation_data import Simulation
from flask_cors import CORS


# todo create route from js to flask + add to mongo result + create simulation html file

def set_up(DURATION, DENSITY, confinement, port_du_mask, border, new_variant):
    global constantes
    global simulation
    constantes = SimulationData(DURATION, DENSITY, confinement, port_du_mask, border, new_variant)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    people = simulation.create_data()
    simulation.update_graph(people)


app = Flask(__name__, static_folder='static')


@app.route('/set', methods=['GET', 'POST'])
def set_simulation():
    if request.method == 'POST':
        post_data = request.get_json()
        print(post_data)
        set_up(int(post_data.get('nombre_jours')), int(post_data.get('population')), bool(post_data.get('confinement')),
               bool(post_data.get('port_mask')),
               bool(post_data.get('deplacement_region')), int(post_data.get('new_variant')))

    response = make_response(render_template('test4.html'))
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
    matplotlib.use('Agg')
    CORS(app)
    sns.set()
    fig = plt.figure(1, figsize=(30, 13))
    app.run(debug=True)
