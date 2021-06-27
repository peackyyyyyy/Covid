class DataSimulation:
    def __init__(self, status, id, DURATION, DENSITY, confinement, port_du_mask, border, new_variant, infected_stats, dead_stats):
        self.id = id
        self.status = status
        self.DURATION = DURATION
        self.DENSITY = DENSITY
        self.confinement = confinement
        self.port_du_mask = port_du_mask
        self.border = border
        self.new_variant = new_variant
        self.infected_stats = infected_stats
        self.dead_stats = dead_stats

    def get_id(self):
        return self.id

    def get_duration(self):
        return self.DURATION

    def get_status(self):
        return self.status

    def get_density(self):
        return self.DENSITY

    def get_confinement(self):
        return self.confinement

    def get_port_du_mask(self):
        return self.port_du_mask

    def get_border(self):
        return self.border

    def get_new_variant(self):
        return self.new_variant

    def get_infected_stats(self):
        return self.infected_stats

    def get_dead_stats(self):
        return self.dead_stats

    def set_infected_stats(self, infected_stats):
        self.infected_stats = infected_stats

    def set_dead_stats(self, dead_stats):
        self.dead_stats = dead_stats