import base64
import io
from time import sleep

import numpy as np
import seaborn as sns
from matplotlib import pyplot as plt, animation
from flask import Flask, send_file, render_template, request, jsonify

from covid_simulation.constantes import SimulationData
from covid_simulation.graph_plot import GraphPlot
from covid_simulation.simulation_data import Simulation


#todo create route from js to flask + add to mongo result + create simulation html file


if __name__ == '__main__':
    fig = plt.figure(1, figsize=(30, 13))
    constantes = SimulationData(5, 30, False, True, False, 15)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    people = simulation.create_data()
    simulation.update_graph(people)
    sns.set()
    anim = animation.FuncAnimation(fig, simulation.next_loop_event, frames=np.arange(constantes.DURATION * 24),
                                   interval=100, repeat=False)
    plt.show()
