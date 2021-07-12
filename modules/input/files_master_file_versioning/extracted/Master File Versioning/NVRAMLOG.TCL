nvm pkgdump NVRAMIMG.img

log open NVRAMLOG.log -nopause

puts "[version]"
device
nvm dir
nvm crc
puts "[vpd show]"

puts "Reading temperature...."
cdbg temp query

log close
