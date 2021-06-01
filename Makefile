VENV := venv
DIR_SOURCE := sources

venv: clean req-app.txt
	python3 -m venv $(VENV)
	$(VENV)/bin/pip install --upgrade pip
	$(VENV)/bin/pip install -r req-app.txt

clean:
	rm -rf $(VENV)
	find . -type f -name '*.pyc' -delete