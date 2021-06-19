from simulation.dataclasses import Person, SIRState
from simulation.simulation import Simulation


class DeadPerson(Person):
    def __init__(self, x, y, simulation: Simulation):
        super().__init__(x, y)
        self.state = SIRState.SUSCEPTIBLE
        self.state = SIRState.DEAD
        self.simulation = simulation
