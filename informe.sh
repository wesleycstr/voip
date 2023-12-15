#/bin/bash

MATRICULA=$1

cat ./modelo.call | sed s/'<MATRICULA>'/$MATRICULA/g > ./$MATRICULA.call

mv ./$MATRICULA.call /var/spool/asterisk/outgoing/
