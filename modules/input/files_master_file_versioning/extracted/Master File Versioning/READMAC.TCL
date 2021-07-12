log open READMAC.txt -nopause

device
puts ["version"]

nvm dir
nvm crc
puts "[vpd show]"

puts " "
puts "Reading temperature...."
cdbg temp query

log close

