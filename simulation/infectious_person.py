import numpy as np

from simulation.dataclasses import Person, SIRState, District
from simulation.dead import DeadPerson
from simulation.recovered_person import RecoveredPerson
from simulation.simulation import Simulation


class InfectiousPerson(Person):
    def __init__(self, x, y, clock, simulation: Simulation):
        super().__init__(x, y)
        self.simulation = simulation
        self.state = SIRState.SUSCEPTIBLE
        self.state = SIRState.INFECTIOUS
        self.date = clock

    def move(self):
        if self.simulation.BORDER is True:
            x = self.district
            y = 2
            originalX = self.x
            originalY = self.y
            if x is District.D7:
                while y is not District.D7:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if self.simulation.LOCKDOWN is True:
                        while originalX - self.x > self.simulation.MAX_HOME_DISTANCE or self.x - originalX > self.simulation.MAX_HOME_DISTANCE or self.y - originalY > self.simulation.MAX_HOME_DISTANCE or originalY - self.y > self.simulation.MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = self.simulation.compute_district(self.x, self.y)

            else:
                while y is not District.D15:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if self.simulation.LOCKDOWN is True:
                        while originalX - self.x > self.simulation.MAX_HOME_DISTANCE or self.x - originalX > self.simulation.MAX_HOME_DISTANCE or self.y - originalY > self.simulation.MAX_HOME_DISTANCE or originalY - self.y > self.simulation.MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = self.simulation.compute_district(self.x, self.y)
        else:
            self.x = np.random.rand()
            self.y = np.random.rand()

    def update(self):
        self.date = self.date + 1
        if np.random.rand() < self.simulation.GAMMA2:
            return DeadPerson(self.x, self.y, self.simulation)
        elif self.date > self.simulation.GAMMA1:
            return RecoveredPerson(self.x, self.y, self.simulation)
        else:
            return self