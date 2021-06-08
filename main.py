import base64
import io

from dataclasses import dataclass
from enum import Enum
import pandas as pd
import numpy as np
import seaborn as sns
import matplotlib.pyplot as plt
from flask import Flask

UNSEEN = 0
INQUEUE = 2
DONE = 1

sns.set()

# Some constants
new_variant = 20
day = []
infected_per_day = []
DURATION = 70  # in days
FRAME_RATE = 25  # Refresh graphics very FRAME_RATE hours
DENSITY = 900
I0 = 0.03
SOCIAL_DISTANCE = 0.003  # in km
SPEED = 6  # km/day
BETA1 = 0.5  # Probality to gets infected (From "S" to "I")
BETA2 = 0.75
GAMMA1 = 7 * 24  # Number of hours before recovering (From "I" to "R")
GAMMA2 = 0.0002  # Probability to die (From "I" to "D")
EPSILON = 0.006  # Probability to be Susceptible again (From "R" to "S")
MAX_HOME_DISTANCE = 0.05
BORDER = False
clock = 0
LOCKDOWN = False
CLUSTERING = True
INFECTED = 0

## The locations of borders on the map

A = (0., 0.82142857)
B = (0.46896552, 0.53125)
C = (0.57241379, 0.58928571)
D = (1., 0.33035714)


class SIRState(Enum):
    SUSCEPTIBLE = 0
    INFECTIOUS = 1
    RECOVERED = 2
    DEAD = 3


class District(Enum):
    D7 = 0
    D15 = 1


@dataclass
class Person:
    x: float  # Normalized x position
    y: float  # normalized y position
    district: District
    is_in_infectious_cluster: bool
    succ: list
    status: int

    def __init__(self, x, y):
        self.x = x
        self.y = y
        self.district = compute_district(x, y)
        self.succ = []
        self.status = UNSEEN
        self.is_in_infectious_cluster = False

    def move(self):
        pass

    def update(self):
        return self


# A Susceptible that moves randomly
class SusceptiblePerson(Person):
    def __init__(self, x, y):
        super().__init__(x, y)
        self.state = SIRState.SUSCEPTIBLE

    def move(self):
        if BORDER is True:
            x = self.district
            y = 2
            originalX = self.x
            originalY = self.y
            if x is District.D7:
                while y is not District.D7:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if LOCKDOWN is True:
                        while originalX - self.x > MAX_HOME_DISTANCE or self.x - originalX > MAX_HOME_DISTANCE or self.y - originalY > MAX_HOME_DISTANCE or originalY - self.y > MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = compute_district(self.x, self.y)

            else:
                while y is not District.D15:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if LOCKDOWN is True:
                        while originalX - self.x > MAX_HOME_DISTANCE or self.x - originalX > MAX_HOME_DISTANCE or self.y - originalY > MAX_HOME_DISTANCE or originalY - self.y > MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = compute_district(self.x, self.y)
        else:
            self.x = np.random.rand()
            self.y = np.random.rand()

    def update(self):
        global INFECTED
        if self.is_in_infectious_cluster is True:
            if np.random.rand() < BETA2:
                INFECTED += 1
                return InfectiousPerson(self.x, self.y)
            else:
                return self
        else:
            for i in self.succ:
                if i.state is SIRState.INFECTIOUS:
                    if np.random.rand() < BETA1:
                        INFECTED += 1
                        return InfectiousPerson(self.x, self.y)
            else:
                return self


# An Infectious that does not move
# But changes to "Susceptible" with probability 0.03
class InfectiousPerson(Person):
    def __init__(self, x, y):
        super().__init__(x, y)
        self.state = SIRState.SUSCEPTIBLE
        self.state = SIRState.INFECTIOUS
        self.date = clock

    def move(self):
        if BORDER is True:
            x = self.district
            y = 2
            originalX = self.x
            originalY = self.y
            if x is District.D7:
                while y is not District.D7:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if LOCKDOWN is True:
                        while originalX - self.x > MAX_HOME_DISTANCE or self.x - originalX > MAX_HOME_DISTANCE or self.y - originalY > MAX_HOME_DISTANCE or originalY - self.y > MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = compute_district(self.x, self.y)

            else:
                while y is not District.D15:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if LOCKDOWN is True:
                        while originalX - self.x > MAX_HOME_DISTANCE or self.x - originalX > MAX_HOME_DISTANCE or self.y - originalY > MAX_HOME_DISTANCE or originalY - self.y > MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = compute_district(self.x, self.y)
        else:
            self.x = np.random.rand()
            self.y = np.random.rand()

    def update(self):
        self.date = self.date + 1
        if np.random.rand() < GAMMA2:
            return DeadPerson(self.x, self.y)
        elif self.date > GAMMA1:
            return RecoveredPerson(self.x, self.y)
        else:
            return self


class RecoveredPerson(Person):
    def __init__(self, x, y):
        super().__init__(x, y)
        self.state = SIRState.RECOVERED

    def move(self):
        if BORDER is True:
            x = self.district
            y = 2
            originalX = self.x
            originalY = self.y
            if x is District.D7:
                while y is not District.D7:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if LOCKDOWN is True:
                        while originalX - self.x > MAX_HOME_DISTANCE or self.x - originalX > MAX_HOME_DISTANCE or self.y - originalY > MAX_HOME_DISTANCE or originalY - self.y > MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = compute_district(self.x, self.y)

            else:
                while y is not District.D15:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if LOCKDOWN is True:
                        while originalX - self.x > MAX_HOME_DISTANCE or self.x - originalX > MAX_HOME_DISTANCE or self.y - originalY > MAX_HOME_DISTANCE or originalY - self.y > MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = compute_district(self.x, self.y)
        else:
            self.x = np.random.rand()
            self.y = np.random.rand()

    def update(self):
        if np.random.rand() < EPSILON:
            return SusceptiblePerson(self.x, self.y)
        else:
            return self


class DeadPerson(Person):
    def __init__(self, x, y):
        super().__init__(x, y)
        self.state = SIRState.SUSCEPTIBLE
        self.state = SIRState.DEAD


def update_graph(people):
    for i in people:
        for w in people:
            if i.district is w.district and i is not w:
                if (((i.x - w.x) ** 2) + ((i.y - w.y) ** 2)) ** 0.5 < SOCIAL_DISTANCE:
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
            x.status = DONE
            for y in x.succ:
                if y.status == UNSEEN:
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


def compute_district(x, y):
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


def display_map(people, ax=None):
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


count_by_population = None


def plot_population(people, ax=None):
    global count_by_population

    states = np.array([p.state.value for p in people], dtype=int)
    counts = np.bincount(states, minlength=4)
    entry = {
        "Susceptible": counts[SIRState.SUSCEPTIBLE.value],
        "Infectious": counts[SIRState.INFECTIOUS.value],
        "Recovered": counts[SIRState.RECOVERED.value],
        "Dead": counts[SIRState.DEAD.value]
    }
    cols = ["Susceptible", "Infectious", "Dead", "Recovered"]
    if count_by_population is None:
        count_by_population = pd.DataFrame(entry, index=[0.])
    else:
        count_by_population = count_by_population.append(entry, ignore_index=True)
    if ax != None:
        count_by_population.index = np.arange(len(count_by_population)) / 24
        sns.lineplot(data=count_by_population, ax=ax)


def plot_statistiques(ax=None):
    global INFECTED
    if ax != None:
        x = np.arange(len(infected_per_day))  # the label locations
        width = 0.2  # the width of the bars

        ax.bar(x - width / DURATION, infected_per_day, width, label='Infected')

        # Add some text for labels, title and custom x-axis tick labels, etc.
        ax.set_ylabel('Number')
        ax.set_title('Infected per Day')
        ax.set_xticks(x)


'''
Main loop function, that is called at each turn
'''

counter = 1


def next_loop_event(t):
    global INFECTED
    global BETA1
    global BETA2
    global counter
    counter += 1
    BETA1 = BETA1 - (0.000001 * counter)
    BETA2 = BETA2 - (0.000002 * counter)
    if t % 24 == 0 and t != 0 and t != 1:
        day.append(t / 24)
        infected_per_day.append(INFECTED)
        INFECTED = 0
    # Move each person
    for p in people:
        p.move()

    if t == new_variant * 24:
        BETA1 = 0.5
        BETA2 = 0.75
        counter = 1
        for p in people:
            if np.random.rand() < I0 / 9:
                p.state = SIRState.INFECTIOUS
            else:
                pass

    update_graph(people)

    # Update the state of people
    for i in range(len(people)):
        people[i] = people[i].update()

    if t % FRAME_RATE == 0:
        fig.clf()
        ax1, ax2, ax3 = fig.subplots(1, 3)
        display_map(people, ax1)
        plot_population(people, ax2)
        plot_statistiques(ax3)
    else:
        plot_population(people, None)


'''
Function that crate the initial population
'''


def create_data():
    # This creates a susceptible person located at (0.25,0.5)
    # and an infectious person located at (0.75,0.5)
    density = []
    for i in range(DENSITY):
        temp = Person(x=np.random.rand(), y=np.random.rand())
        if i < DENSITY * 0.03:
            density.append(InfectiousPerson(temp.x, temp.y))
        else:
            density.append(SusceptiblePerson(temp.x, temp.y))
    return density


import matplotlib.animation as animation

# To save the animation as a video
# anim.save("simulation.mp4", fps=5, dpi=100, writer="ffmpeg")


app = Flask(__name__)


@app.route('/simulation', methods=['GET'])
def build_plot():
    img = io.BytesIO()
    anim = animation.FuncAnimation(fig, next_loop_event, frames=np.arange(DURATION * 24), interval=100, repeat=False)
    plt.savefig(img, format='png')
    img.seek(0)

    plot_url = base64.b64encode(img.getvalue()).decode()

    return '<img src="data:image/png;base64,{}">'.format(plot_url)


if __name__ == '__main__':
    people = create_data()
    update_graph(people)

    fig = plt.figure(1, figsize=(30, 13))
    app.debug = True
    app.run()
