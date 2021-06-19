import numpy as np

from simulation.dataclasses import Person, SIRState, District
from simulation.infectious_person import InfectiousPerson
from simulation.simulation import Simulation


class SusceptiblePerson(Person):
    def __init__(self, x, y, simulation: Simulation):
        super().__init__(x, y)
        self.simulation = simulation
        self.state = SIRState.SUSCEPTIBLE

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
        global INFECTED
        if self.is_in_infectious_cluster is True:
            if np.random.rand() < self.simulation.BETA2:
                INFECTED += 1
                return InfectiousPerson(self.x, self.y, 0, self.simulation)
            else:
                return self
        else:
            for i in self.succ:
                if i.state is SIRState.INFECTIOUS:
                    if np.random.rand() < self.simulation.BETA1:
                        INFECTED += 1
                        return InfectiousPerson(self.x, self.y, 0, self.simulation)
            else:
                return self