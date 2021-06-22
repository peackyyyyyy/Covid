import base64
import io
from time import sleep

import numpy as np
import seaborn as sns
from matplotlib import pyplot as plt, animation
from flask import Flask, send_file, render_template, request, jsonify
from covid_simulation.constantes import Constantes
from covid_simulation.graph_plot import GraphPlot
from covid_simulation.simulation_data import Simulation


#todo create route from js to flask + add to mongo result + create simulation html file

def set_up(DURATION, DENSITY, confinement, port_du_mask, border, new_variant):
    global constantes
    global simulation
    constantes = Constantes(DURATION, DENSITY, confinement, port_du_mask, border, new_variant)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    people = simulation.create_data()
    simulation.update_graph(people)


app = Flask(__name__, static_folder='static')


@app.route('/set', methods=['GET', 'POST'])
def set_simulation():
    if request.method == 'POST':
        post_data = request.get_json()
        set_up(post_data.get('nombre_jours'), post_data.get('population'), post_data.get('confinement'), post_data.get('port_mask'),
               post_data.get('deplacement_region'), post_data.get('new_variant'))
    return jsonify("ok")


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
    sns.set()
    fig = plt.figure(1, figsize=(30, 13))
    app.run(debug=True)
