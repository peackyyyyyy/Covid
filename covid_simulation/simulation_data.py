from enum import Enum

import numpy as np

from covid_simulation.constantes import SimulationData, SIRState, District
from covid_simulation.graph_plot import GraphPlot
from covid_simulation.person import Person, InfectiousPerson, SusceptiblePerson


class Simulation:

    def __init__(self, constantes: SimulationData, graphplot: GraphPlot):
        self.constantes = constantes
        self.graphplot = graphplot
        self.counter = 1

    def update_graph(self, people):
        for i in people:
            for w in people:
                if i.district is w.district and i is not w:
                    if (((i.x - w.x) ** 2) + ((i.y - w.y) ** 2)) ** 0.5 < self.constantes.SOCIAL_DISTANCE:
                        i.succ.append(w)
                    else:
                        pass
                else:
                    pass
        for i in people:
            cluster = []
            Q = [i]
            while Q:
                x = Q.pop(0)
                cluster.append(x)
                x.status = self.constantes.DONE
                for y in x.succ:
                    if y.status == self.constantes.UNSEEN:
                        Q.append(y)
            infected = 0
            for w in cluster:
                if w.state is SIRState.INFECTIOUS:
                    infected = infected + 1
                else:
                    pass
            if infected / len(cluster) >= 0.33:
                for y in cluster:
                    y.is_in_infectious_cluster = True
            else:
                pass



    '''
    Main loop function, that is called at each turn
    '''

    def next_loop_event(self, t):
        self.counter += 1
        self.constantes.BETA1 = self.constantes.BETA1 - (0.000001 * self.counter)
        self.constantes.BETA2 = self.constantes.BETA2 - (0.000002 * self.counter)
        if t % 24 == 0 and t != 0 and t != 1:
            self.constantes.day.append(t / 24)
            self.constantes.infected_per_day.append(self.constantes.INFECTED)
            self.constantes.INFECTED = 0
        # Move each person
        for p in self.constantes.people:
            p.move()

        if t == self.constantes.new_variant * 24:
            self.constantes.BETA1 = 0.5
            self.constantes.BETA2 = 0.75
            self.constantes.counter = 1
            for p in self.constantes.people:
                if np.random.rand() < self.constantes.I0 / 9:
                    p.state = SIRState.INFECTIOUS
                else:
                    pass

        self.update_graph(self.constantes.people)

        # Update the state of people
        for i in range(len(self.constantes.people)):
            self.constantes.people[i] = self.constantes.people[i].update()

        if t % self.constantes.FRAME_RATE == 0:
            self.graphplot.fig.clf()
            ax1, ax2 = self.graphplot.fig.subplots(1, 2)
            self.graphplot.display_map(self.constantes.people, ax1)
            self.graphplot.plot_population(self.constantes.people, ax2)
            #self.graphplot.plot_statistiques(self.constantes.infected_per_day, ax3)
        else:
            self.graphplot.plot_population(self.constantes.people)

    '''
    Function that crate the initial population
    '''

    def create_data(self):
        # This creates a susceptible person located at (0.25,0.5)
        # and an infectious person located at (0.75,0.5)
        for i in range(self.constantes.DENSITY):
            temp = Person(np.random.rand(), np.random.rand(), self.constantes)
            if i < self.constantes.DENSITY * 0.03:
                self.constantes.people.append(InfectiousPerson(temp.x, temp.y, 0, self.constantes))
            else:
                self.constantes.people.append(SusceptiblePerson(temp.x, temp.y, self.constantes))
        return self.constantes.people
