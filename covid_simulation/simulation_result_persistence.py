from typing import List

from bson import ObjectId

from covid_simulation.Data_Simulation import DataSimulation
from covid_simulation.Status import Status
from covid_simulation.database_adapter import DatabaseAdapter


class SimulationPersistence:

    def __init__(self, database_adapter: DatabaseAdapter):
        self._database_adapter = database_adapter

    def find_one_and_update_simulation(self, id, status, infected_stats, dead_stats) -> str:
        path_dict = {
            '$set': {'status': status, "infected_stats": infected_stats,
                     "dead_stats": dead_stats}}
        return self._database_adapter.find_one_and_update(id, path_dict)

    def find_simulations(self, doc: dict = None) -> List[DataSimulation]:
        data_simulations = []
        results = self._database_adapter.find(doc)
        for result in results:
            data_simulations.append(
                DataSimulation(str(result['_id']), result['status'],  result['duration'], result['density'], result['confinement'],
                               result['port_mask'], result['border'], result['new_variant'],
                               result['infected_stats'], result['dead_stats']))
        return data_simulations

    def find_one_simulation_by_id(self, id: str) -> DataSimulation:
        doc = {"_id": ObjectId(id)}
        result = self._database_adapter.find_one(doc)
        return DataSimulation(str(result['_id']), result['status'], result['duration'], result['density'], result['confinement'],
                              result['port_mask'], result['border'], result['new_variant'],
                              result['infected_stats'], result['dead_stats'])

    def find_simulations_by_ids(self, ids: List[str]) -> List[DataSimulation]:
        objected_ids = []
        for id in ids:
            objected_ids.append(ObjectId(id))
        list_data_simulations = []
        doc = {"_id": {"$in": objected_ids}}
        results = self._database_adapter.find(doc)
        for result in results:
            data_simulations = DataSimulation(str(result['_id']), result['status'], result['duration'], result['density'],
                                              result['confinement'],
                                              result['port_mask'], result['border'], result['new_variant'],
                                              result['infected_stats'], result['dead_stats'])
            list_data_simulations.append(data_simulations)
        return list_data_simulations

    def insert_one_simulation(self, status: Status, DURATION, DENSITY, confinement, port_du_mask, border, new_variant,
                              infected_stats, dead_stats) -> str:
        doc = {"status": status, "duration": DURATION, "density": DENSITY, "confinement": confinement, "port_mask": port_du_mask,
               "border": border, "new_variant": new_variant, "infected_stats": infected_stats,
               "dead_stats": dead_stats}
        return self._database_adapter.insert_one(doc)
