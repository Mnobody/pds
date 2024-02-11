#!/bin/sh
set -e

# container sets up minio data and dies

echo "$(mc config host add myminioserver http://minio:9000 minioadmin minioadmin)"

# minio client make bucket 'pdt'
echo "$(mc mb myminioserver/pdt --ignore-existing)"

# populate bucket with files
echo "$(mc mirror --overwrite --remove /data/ myminioserver/pdt/)"

exit 0;
