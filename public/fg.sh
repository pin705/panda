step=60 #间隔的秒数，不能大于60

for (( i = 0; i < 60; i=(i+step) )); do
    $(curl 'http://www.90175.com/growUp')
    sleep $step
    done

exit 0
