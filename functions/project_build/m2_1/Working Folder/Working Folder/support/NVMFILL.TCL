puts "Erasing SBI"
nvm fill 0x000000 0x20000 0
puts "Erasing SBI"
nvm fill 0x080000 0x20000 0
puts "Erasing directory"
nvm fill 0x100000 0x10000 0

