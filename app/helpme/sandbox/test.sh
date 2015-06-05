#!/usr/bin/env bash

main(){
FRCV=/tmp/rcv.txt
dialog --title "Check Off" --checklist "The selection" 20 35 3 \
1 fun on \
2 tomato off \
3 rabbits on 2>"${FRCV}"

VRCV=$(<"${FRCV}")

case $VRCV in
1) clear ; echo ; echo ; exec ls -lah;;
2) clear ; exec man man;;
3) clear ; dialog --infobox "We are done!" 10 20 ; sleep 1 ; clear;;
esac



}

main
