from typing import List

from bson import ObjectId

from covid_simulation.database_adapter import DatabaseAdapter


class DataframeLabeledPersistence:

    def __init__(self, database_adapter: DatabaseAdapter):
        self._database_adapter = database_adapter

    def find_one_and_update_dataframe(self, dataframe: dict, label: int, sha256: str) -> str:
        path_dict = {'$set': {"dataframe": dataframe, "label": label, "sha256": sha256}}
        return self._database_adapter.find_one_and_update(sha256, path_dict)

    def find_dataframes(self, doc: dict = None) -> List[DataframeLabeled]:
        label_dataframes = []
        results = self._database_adapter.find(doc)
        for result in results:
            label_dataframes.append(DataframeLabeled(str(result['_id']), result['dataframe'], result['label'], result['sha256']))
        return label_dataframes

    def find_one_simulation_by_id(self, id: str) -> DataframeLabeled:
        doc = {"_id": ObjectId(id)}
        result = self._database_adapter.find_one(doc)
        return DataframeLabeled(str(result['_id']), result['dataframe'], result['label'], result['sha256'])

    def find_simulations_by_ids(self, ids: List[str]) -> List[DataframeLabeled]:
        objected_ids = []
        for id in ids:
            objected_ids.append(ObjectId(id))
        list_dataframe_labeled = []
        doc = {"_id": {"$in": objected_ids}}
        results = self._database_adapter.find(doc)
        for result in results:
            dataframe_labeled = DataframeLabeled(str(result['_id']), result['dataframe'], result['label'], result['sha256'])
            list_dataframe_labeled.append(dataframe_labeled)
        return list_dataframe_labeled

    def insert_one_simulation(self, dataframe: dict, label: int, sha256: str) -> str:
        doc = {"dataframe": dataframe, "label": label, "sha256": sha256}
        return self._database_adapter.insert_one(doc)
