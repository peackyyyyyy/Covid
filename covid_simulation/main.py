import numpy as np
import seaborn as sns
from matplotlib import pyplot as plt, animation

from covid_simulation.constantes import Constantes
from covid_simulation.graph_plot import GraphPlot
from covid_simulation.simulation_data import Simulation

if __name__ == '__main__':
    sns.set()
    fig = plt.figure(1, figsize=(30, 13))
    constantes = Constantes()
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    people = simulation.create_data()
    simulation.update_graph(people)
    anim = animation.FuncAnimation(fig, simulation.next_loop_event, frames=np.arange(constantes.DURATION * 24), interval=100, repeat=False)
    plt.show()