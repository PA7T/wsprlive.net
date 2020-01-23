# wsprlive.net
Scripts for running wsprlive.net

# Prerequisites

A python virtual environment > 3.4 should be installed with the following packages:

```bash
pip install beautifulsoup4 certifi chardet future idna influxdb pyephem pyhamtools python-dateutil python-geohash pytz redis requests setuptools six urllib3 wheel
```
# Workflow logic
1. files are uploaded to non-web accessible directory via post.php
2. the systemd managed script pass-uploads.sh monitors the directory for new files and executes
3. the python script wspr_to_curl_dev.py, pipes the output to curl and ingests the new data in a InfluxDB database and deletes the processed file
