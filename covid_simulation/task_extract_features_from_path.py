
from celery import Celery
import os

celery_app = Celery('task')


@celery_app.task(queue='features_extractor', name='extract_features_from_path')
def extract_features_from_path(id, DURATION, DENSITY, confinement, port_du_mask, border, new_variant, infected_stats, dead_stats):
   pass
