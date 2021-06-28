import matplotlib
import seaborn as sns
from celery import Celery
import os

from matplotlib import pyplot as plt
from pymongo import MongoClient

from covid_simulation.Status import Status
from covid_simulation.constantes import SimulationData
from covid_simulation.database_adapter import DatabaseAdapter
from covid_simulation.graph_plot import GraphPlot
from covid_simulation.simulation_data import Simulation
from covid_simulation.simulation_result_persistence import SimulationPersistence

celery_app = Celery('task', broker='redis://localhost:6379/0')

client = MongoClient('localhost')
database = client.get_database('simulation')
collection = database.get_collection('result')
matplotlib.use('Agg')
sns.set()
fig = plt.figure(1, figsize=(30, 13))


# cd into Covid file
# to start the workers

@celery_app.task(queue='simulation', name='result_simulation')
def calcule_result_of_simulation(id, DURATION, DENSITY, confinement, port_du_mask, border, new_variant, infected_stats,
                                 dead_stats):
    database_adapter = DatabaseAdapter(collection)
    simulation_persistence = SimulationPersistence(database_adapter)
    constantes = SimulationData(DURATION, DENSITY, confinement, port_du_mask, border, new_variant)
    graphplot = GraphPlot(constantes, fig)
    simulation = Simulation(constantes, graphplot)
    people = simulation.create_data()
    simulation.update_graph(people)
    for i in range(DURATION * 24):
        simulation.next_loop_event(i)
    simulation_persistence.find_one_and_update_simulation(id, Status.FINISH, constantes.infected_per_day, constantes.dead_per_day)
