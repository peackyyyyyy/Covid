from typing import List
from celery import Celery, chain


class MessageBrokerAdapter:

    def __init__(self, celery_app: Celery):
        self._celery_app = celery_app

    def send_async(self, args: List, task_name: str, queue_name: str):
        s = self._celery_app.signature(task_name, args=args, queue=queue_name)
        s.apply_async()

    def send_async_chain(self, args_train: List, args_test: List, task_1_name: str, task_2_name: str, queue_name: str):
        train = self._celery_app.signature(task_1_name, args=args_train, queue=queue_name)
        test = self._celery_app.signature(task_2_name, args=args_test, queue=queue_name)
        chain(train, test).apply_async()
