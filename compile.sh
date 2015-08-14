#! /bin/bash
set -e
cwd=$(dirname $0)
cd $cwd
for compiler in **/compile.sh; do
	if [ "$compiler" != './compile.sh' ]; then
		cd $(dirname $compiler)
		./compile.sh
		cd $cwd
	fi
done
