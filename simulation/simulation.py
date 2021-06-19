import numpy as np
import pandas as pd
import seaborn as sns
from simulation.dataclasses import SIRState, District, Person
from simulation.infectious_person import InfectiousPerson
from simulation.susceptible_person import SusceptiblePerson


class Simulation:
    def __init__(self):
        self.UNSEEN = 0
        self.INQUEUE = 2
        self.DONE = 1
        self.fig = None
        self.count_by_population = None
        sns.set()
        self.people = []
        # Some constants
        self.new_variant = 20
        self.day = []
        self.infected_per_day = []
        self.DURATION = 1  # in days
        self.FRAME_RATE = 2  # Refresh graphics very FRAME_RATE hours
        self.DENSITY = 900
        self.I0 = 0.03
        self.SOCIAL_DISTANCE = 0.003  # in km
        self.SPEED = 6  # km/day
        self.BETA1 = 0.5  # Probality to gets infected (From "S" to "I")
        self.BETA2 = 0.75
        self.GAMMA1 = 7 * 24  # Number of hours before recovering (From "I" to "R")
        self.GAMMA2 = 0.0002  # Probability to die (From "I" to "D")
        self.EPSILON = 0.006  # Probability to be Susceptible again (From "R" to "S")
        self.MAX_HOME_DISTANCE = 0.05
        self.BORDER = False
        self.clock = 0
        self.LOCKDOWN = False
        self.CLUSTERING = True
        self.INFECTED = 0
        self.A = (0., 0.82142857)
        self.B = (0.46896552, 0.53125)
        self.C = (0.57241379, 0.58928571)
        self.D = (1., 0.33035714)

    def update_graph(self, people):
        for i in people:
            for w in people:
                if i.district is w.district and i is not w:
                    if (((i.x - w.x) ** 2) + ((i.y - w.y) ** 2)) ** 0.5 < self.SOCIAL_DISTANCE:
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
                x.status = self.DONE
                for y in x.succ:
                    if y.status == self.UNSEEN:
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

    def compute_district(self, x, y):
        if -y - 0.61876300068982 * x + 0.8214285 <= 0 and -y + 0.5610121780756 * x + 0.26815464340269 <= 0:
            return District.D7
        elif -y + 0.5610121780756 * x + 0.26815464340269 >= 0 and -y - 0.60555869072512 * x + 0.93591579072512 <= 0:
            return District.D7
        else:
            return District.D15

    '''
    Fonctions used to display and plot the curves
    (you should not have to change them)
    '''

    def display_map(self, ax=None):
        x = [p.x for p in self.people]
        y = [p.y for p in self.people]
        h = [p.state.name[0] for p in self.people]
        horder = ["S", "I", "R", "D"]
        ax = sns.scatterplot(x, y, hue=h, hue_order=horder, ax=ax)
        ax.set_xlim((0.0, 1.0))
        ax.set_ylim((0.0, 1.0))
        ax.set_aspect(224 / 145)
        ax.set_axis_off()
        ax.set_frame_on(True)
        ax.legend(loc=1, bbox_to_anchor=(0, 1))


    def plot_population(self, ax=None):

        states = np.array([p.state.value for p in self.people], dtype=int)
        counts = np.bincount(states, minlength=4)
        entry = {
            "Susceptible": counts[SIRState.SUSCEPTIBLE.value],
            "Infectious": counts[SIRState.INFECTIOUS.value],
            "Recovered": counts[SIRState.RECOVERED.value],
            "Dead": counts[SIRState.DEAD.value]
        }
        cols = ["Susceptible", "Infectious", "Dead", "Recovered"]
        if self.count_by_population is None:
            count_by_population = pd.DataFrame(entry, index=[0.])
        else:
            count_by_population = self.count_by_population.append(entry, ignore_index=True)
        if ax != None:
            count_by_population.index = np.arange(len(count_by_population)) / 24
            sns.lineplot(data=count_by_population, ax=ax)

    def plot_statistiques(self, ax=None):
        global INFECTED
        if ax != None:
            x = np.arange(len(self.infected_per_day))  # the label locations
            width = 0.2  # the width of the bars

            ax.bar(x - width / self.DURATION, self.infected_per_day, width, label='Infected')

            # Add some text for labels, title and custom x-axis tick labels, etc.
            ax.set_ylabel('Number')
            ax.set_title('Infected per Day')
            ax.set_xticks(x)

    '''
    Main loop function, that is called at each turn
    '''

    counter = 1

    def next_loop_event(self, t):
        global INFECTED
        global BETA1
        global BETA2
        global counter
        counter += 1
        BETA1 = BETA1 - (0.000001 * counter)
        BETA2 = BETA2 - (0.000002 * counter)
        if t % 24 == 0 and t != 0 and t != 1:
            self.day.append(t / 24)
            self.infected_per_day.append(INFECTED)
            INFECTED = 0
        # Move each person
        for p in self.people:
            p.move()

        if t == self.new_variant * 24:
            BETA1 = 0.5
            BETA2 = 0.75
            counter = 1
            for p in self.people:
                if np.random.rand() < self.I0 / 9:
                    p.state = SIRState.INFECTIOUS
                else:
                    pass

        self.update_graph(self.people)

        # Update the state of people
        for i in range(len(self.people)):
            self.people[i] = self.people[i].update()

        if t % self.FRAME_RATE == 0:
            self.fig.clf()
            ax1, ax2, ax3 = self.fig.subplots(1, 3)
            self.display_map(self.people, ax1)
            self.plot_population(self.people, ax2)
            self.plot_statistiques(ax3)
        else:
            self.plot_population(self.people)

    '''
    Function that crate the initial population
    '''

    def create_data(self):
        # This creates a susceptible person located at (0.25,0.5)
        # and an infectious person located at (0.75,0.5)
        for i in range(self.DENSITY):
            temp = Person(x=np.random.rand(), y=np.random.rand())
            if i < self.DENSITY * 0.03:
                self.people.append(InfectiousPerson(temp.x, temp.y))
            else:
                self.people.append(SusceptiblePerson(temp.x, temp.y))