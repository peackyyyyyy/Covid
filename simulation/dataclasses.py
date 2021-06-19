from enum import Enum

from simulation.simulation import Simulation


class SIRState(Enum):
    SUSCEPTIBLE = 0
    INFECTIOUS = 1
    RECOVERED = 2
    DEAD = 3


class District(Enum):
    D7 = 0
    D15 = 1

class Person:
    x: float  # Normalized x position
    y: float  # normalized y position
    district: District
    is_in_infectious_cluster: bool
    succ: list
    status: int

    def __init__(self, x, y, simulation: Simulation):
        self.x = x
        self.y = y
        self.simulation = simulation
        self.district = self.simulation.compute_district(x, y)
        self.succ = []
        self.status = self.simulation.UNSEEN
        self.is_in_infectious_cluster = False

    def move(self):
        pass

    def update(self):
        return self