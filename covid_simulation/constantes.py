from enum import Enum


class Constantes:
    def __init__(self, DURATION, DENSITY, confinement, port_du_mask, border, new_variant):
        self.UNSEEN = 0
        self.INQUEUE = 2
        self.DONE = 1
        self.fig = None
        self.count_by_population = None
        self.people = []
        # Some constants
        self.new_variant = new_variant
        self.day = []
        self.infected_per_day = []
        self.DURATION = DURATION  # in days
        self.FRAME_RATE = 2  # Refresh graphics very FRAME_RATE hours
        self.DENSITY = DENSITY
        self.I0 = 0.03
        self.SOCIAL_DISTANCE = 0.003  # in km
        self.SPEED = 6  # km/day
        self.BETA1 = 0.5  # Probality to gets infected (From "S" to "I")
        self.BETA2 = 0.75
        self.GAMMA1 = 7 * 24  # Number of hours before recovering (From "I" to "R")
        self.GAMMA2 = 0.0002  # Probability to die (From "I" to "D")
        self.EPSILON = 0.006  # Probability to be Susceptible again (From "R" to "S")
        self.MAX_HOME_DISTANCE = 0.05
        self.BORDER = border
        self.clock = 0
        self.LOCKDOWN = confinement
        self.CLUSTERING = port_du_mask
        self.INFECTED = 0
        self.A = (0., 0.82142857)
        self.B = (0.46896552, 0.53125)
        self.C = (0.57241379, 0.58928571)
        self.D = (1., 0.33035714)

    def compute_district(self, x, y):
        if -y - 0.61876300068982 * x + 0.8214285 <= 0 and -y + 0.5610121780756 * x + 0.26815464340269 <= 0:
            return District.D7
        elif -y + 0.5610121780756 * x + 0.26815464340269 >= 0 and -y - 0.60555869072512 * x + 0.93591579072512 <= 0:
            return District.D7
        else:
            return District.D15


class SIRState(Enum):
    SUSCEPTIBLE = 0
    INFECTIOUS = 1
    RECOVERED = 2
    DEAD = 3


class District(Enum):
    D7 = 0
    D15 = 1


class Queue(Enum):
    UNSEEN = 0
    INQUEUE = 2
    DONE = 1
