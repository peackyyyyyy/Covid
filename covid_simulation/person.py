import numpy as np
from dataclasses import dataclass

from covid_simulation.constantes import SimulationData, District, SIRState


@dataclass
class Person:
    x: float  # Normalized x position
    y: float  # normalized y position
    district: District
    is_in_infectious_cluster: bool
    succ: list
    status: int

    def __init__(self, x, y, constantes: SimulationData):
        self.constantes = constantes
        self.x = x
        self.y = y
        self.district = self.constantes.compute_district(x, y)
        self.succ = []
        self.status = 0
        self.is_in_infectious_cluster = False

    def move(self):
        pass

    def update(self):
        return self


class RecoveredPerson(Person):
    def __init__(self, x, y, constantes: SimulationData):
        super().__init__(x, y, constantes)
        self.constantes = constantes
        self.state = SIRState.RECOVERED

    def move(self):
        if self.constantes.BORDER is True:
            x = self.district
            y = 2
            originalX = self.x
            originalY = self.y
            if x is District.D7:
                while y is not District.D7:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if self.constantes.LOCKDOWN is True:
                        while originalX - self.x > self.constantes.MAX_HOME_DISTANCE or self.x - originalX > self.constantes.MAX_HOME_DISTANCE or self.y - originalY > self.constantes.MAX_HOME_DISTANCE or originalY - self.y > self.constantes.MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = self.constantes.compute_district(self.x, self.y)

            else:
                while y is not District.D15:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if self.constantes.LOCKDOWN is True:
                        while originalX - self.x > self.constantes.MAX_HOME_DISTANCE or self.x - originalX > self.constantes.MAX_HOME_DISTANCE or self.y - originalY > self.constantes.MAX_HOME_DISTANCE or originalY - self.y > self.constantes.MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = self.constantes.compute_district(self.x, self.y)
        else:
            self.x = np.random.rand()
            self.y = np.random.rand()

    def update(self):
        if np.random.rand() < self.constantes.EPSILON:
            return SusceptiblePerson(self.x, self.y, self.constantes)
        else:
            return self


class InfectiousPerson(Person):
    def __init__(self, x, y, clock, constantes: SimulationData):
        super().__init__(x, y, constantes)
        self.constantes = constantes
        self.state = SIRState.SUSCEPTIBLE
        self.state = SIRState.INFECTIOUS
        self.date = clock

    def move(self):
        if self.constantes.BORDER is True:
            x = self.district
            y = 2
            originalX = self.x
            originalY = self.y
            if x is District.D7:
                while y is not District.D7:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if self.constantes.LOCKDOWN is True:
                        while originalX - self.x > self.constantes.MAX_HOME_DISTANCE or self.x - originalX > self.constantes.MAX_HOME_DISTANCE or self.y - originalY > self.constantes.MAX_HOME_DISTANCE or originalY - self.y > self.constantes.MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = self.constantes.compute_district(self.x, self.y)

            else:
                while y is not District.D15:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if self.constantes.LOCKDOWN is True:
                        while originalX - self.x > self.constantes.MAX_HOME_DISTANCE or self.x - originalX > self.constantes.MAX_HOME_DISTANCE or self.y - originalY > self.constantes.MAX_HOME_DISTANCE or originalY - self.y > self.constantes.MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = self.constantes.compute_district(self.x, self.y)
        else:
            self.x = np.random.rand()
            self.y = np.random.rand()

    def update(self):
        self.date = self.date + 1
        if np.random.rand() < self.constantes.GAMMA2:
            return DeadPerson(self.x, self.y, self.constantes)
        elif self.date > self.constantes.GAMMA1:
            return RecoveredPerson(self.x, self.y, self.constantes)
        else:
            return self


class SusceptiblePerson(Person):
    def __init__(self, x, y, constantes: SimulationData):
        super().__init__(x, y, constantes)
        self.constantes = constantes
        self.state = SIRState.SUSCEPTIBLE

    def move(self):
        if self.constantes.BORDER is True:
            x = self.district
            y = 2
            originalX = self.x
            originalY = self.y
            if x is District.D7:
                while y is not District.D7:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if self.constantes.LOCKDOWN is True:
                        while originalX - self.x > self.constantes.MAX_HOME_DISTANCE or self.x - originalX > self.constantes.MAX_HOME_DISTANCE or self.y - originalY > self.constantes.MAX_HOME_DISTANCE or originalY - self.y > self.constantes.MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = self.constantes.compute_district(self.x, self.y)

            else:
                while y is not District.D15:
                    self.x = np.random.rand()
                    self.y = np.random.rand()
                    if self.constantes.LOCKDOWN is True:
                        while originalX - self.x > self.constantes.MAX_HOME_DISTANCE or self.x - originalX > self.constantes.MAX_HOME_DISTANCE or self.y - originalY > self.constantes.MAX_HOME_DISTANCE or originalY - self.y > self.constantes.MAX_HOME_DISTANCE:
                            self.x = np.random.rand()
                            self.y = np.random.rand()
                    y = self.constantes.compute_district(self.x, self.y)
        else:
            self.x = np.random.rand()
            self.y = np.random.rand()

    def update(self):
        if self.is_in_infectious_cluster is True:
            if np.random.rand() < self.constantes.BETA2:
                self.constantes.INFECTED += 1
                return InfectiousPerson(self.x, self.y, 0, self.constantes)
            else:
                return self
        else:
            for i in self.succ:
                if i.state is SIRState.INFECTIOUS:
                    if np.random.rand() < self.constantes.BETA1:
                        self.constantes.INFECTED += 1
                        return InfectiousPerson(self.x, self.y, 0, self.constantes)
            else:
                return self


class DeadPerson(Person):
    def __init__(self, x, y, constantes: SimulationData):
        super().__init__(x, y, constantes)
        self.state = SIRState.SUSCEPTIBLE
        self.state = SIRState.DEAD
