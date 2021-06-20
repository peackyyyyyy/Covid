import numpy as np
import pandas as pd
from matplotlib import pyplot as plt
import seaborn as sns

from covid_simulation.constantes import Constantes, SIRState


class GraphPlot:
    def __init__(self, constantes: Constantes, fig):
        self.constantes = constantes
        self.fig = fig
        self.count_by_population = None

    def display_map(self, people, ax=None):
        x = [p.x for p in people]
        y = [p.y for p in people]
        h = [p.state.name[0] for p in people]
        horder = ["S", "I", "R", "D"]
        ax = sns.scatterplot(x, y, hue=h, hue_order=horder, ax=ax)
        ax.set_xlim((0.0, 1.0))
        ax.set_ylim((0.0, 1.0))
        ax.set_aspect(224 / 145)
        ax.set_axis_off()
        ax.set_frame_on(True)
        ax.legend(loc=1, bbox_to_anchor=(0, 1))

    def plot_population(self, people, ax=None):
        states = np.array([p.state.value for p in people], dtype=int)
        counts = np.bincount(states, minlength=4)
        entry = {
            "Susceptible": counts[SIRState.SUSCEPTIBLE.value],
            "Infectious": counts[SIRState.INFECTIOUS.value],
            "Recovered": counts[SIRState.RECOVERED.value],
            "Dead": counts[SIRState.DEAD.value]
        }
        cols = ["Susceptible", "Infectious", "Dead", "Recovered"]
        if self.count_by_population is None:
            self.count_by_population = pd.DataFrame(entry, index=[0.])
        else:
            self.count_by_population = self.count_by_population.append(entry, ignore_index=True)
        if ax != None:
            self.count_by_population.index = np.arange(len(self.count_by_population)) / 24
            sns.lineplot(data=self.count_by_population, ax=ax)

    def plot_statistiques(self, infected_per_day, ax=None):
        if ax != None:
            x = np.arange(len(infected_per_day))  # the label locations
            width = 0.2  # the width of the bars
            ax.bar(x - width / self.constantes.DURATION, infected_per_day, width, label='Infected')

            # Add some text for labels, title and custom x-axis tick labels, etc.
            ax.set_ylabel('Number')
            ax.set_title('Infected per Day')
            ax.set_xticks(x)