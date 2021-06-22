from bson import ObjectId
from pymongo import ReturnDocument
from pymongo.collection import Collection


class DatabaseAdapter:

    def __init__(self, collection: Collection):
        self._collection = collection

    def insert_one(self, doc: dict) -> str:
        try:
            return str(self._collection.insert_one(doc).inserted_id)
        except Exception as e:
            print(e.args)

    def find_one(self, doc: dict) -> dict:
        try:
            result = self._collection.find_one(doc)  # Dans le try seulement la ligne qui pose
            return result
            # probleme ici : self._collection.find_one(doc)
        except Exception as e:
            print(e.args)

    def find(self, doc: dict = None) -> list:  # find ne me renverra pas d'exception mais des liste vide
        return list(self._collection.find(doc))

    def update_one_by_id(self, id: str, doc: dict):
        try:
            filter = {"_id": ObjectId(id)}
            result = self._collection.update_one(filter, doc)
            return result
        except Exception as e:
            print(e.args)

    def find_one_and_update(self, sha256: str, doc: dict) -> str:
        filter = {"sha256": sha256}
        result = self._collection.find_one_and_update(filter, doc, upsert=True, return_document=ReturnDocument.AFTER)
        return str(result['_id'])



