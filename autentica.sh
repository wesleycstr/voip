#/bin/bash

MATRICULA=$1

cat ./modelo_autentica.call | sed s/'<MATRICULA>'/$MATRICULA/g > ./$MATRICULA.call

mv ./$MATRICULA.call /var/spool/asterisk/outgoing/
