fwutil
dump_all_cfg NVRAMCFG.cfg
nvm pkgdump NVRAMIMG.img

log open NVRAMLOG.log -nopause

device
nvm dir
nvm crc
puts "[vpd show]"

log close

