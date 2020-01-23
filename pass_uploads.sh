#!/bin/bash

# activate pyenv
source /PATHTO/pyv34venv/bin/activate

WLID="INFLUXDB_USER"
WLPW="INFLUXDB_PW"
CTYFILE="/PATHTO/clublogdata/cty.xml"

inotifywait -m /PATHTO_DIRECTORY_WITH_FILES/uploads -e create -e moved_to |
    while read path action file; do
        # CUDOS: Drav Sloan - https://unix.stackexchange.com/questions/24952/script-to-monitor-folder-for-new-files#answer-24955
        echo "The file '$file' appeared in directory '$path' via '$action'"

        # retrieve call and locator from POST variables TODO: sanitize inputs
      	OIFS=$IFS;
      	IFS="_";
      	fileArray=($file);
      	call=${fileArray[1]}
      	call=${call//-/\/}
      	locator=${fileArray[2]}
      	IFS=$OIFS;

        # parse uploaded file with python scrip and upload via curl to local InfluxDB
        python3 /PATHTO/wspr_to_curl_dev.py -r $call -rl $locator -rc "none" -fc $CTYFILE -fi $path$file | curl -u $WLID:$WLPW -i -XPOST 'http://127.0.0.1:8086/write?db=wspr&precision=s' --data-binary @-

        # remove file if parsing was successful
        test $? -ne 0 || rm -f $path$file
    done
