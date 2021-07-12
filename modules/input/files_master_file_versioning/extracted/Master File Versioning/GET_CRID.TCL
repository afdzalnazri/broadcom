set logfile [open "CRID.log" w]
set crid [get_crid]
set crid [get_crid]
fwutil
puts $logfile "$crid"
close $logfile

