RAW Offset: FRU Item  (data length)
0x0:	[HEADER Start]
0x7:	[Header checksum]
0x8:	[BOARD Start]
0xb:	date = cb92cd	(3)			***Need to update during manufacturing***
0xf:	manufacturer = Broadcom	(8)
0x18:	product = BRCM 100G 1P 57504 OCP Mezz	(27)
0x34:	serial = N1100FX19210001YCQ	(18)	***Need to update during manufacturing***
0x47:	part = BCM957504-N1100FXB	(18)
0x5a:	fileid = 05/13/2021	(10)
0x67:	[Board checksum] = cb	(1)		***Need to update during manufacturing***
0x68:	[Product Start]
0x6c:	manufacturer = Broadcom	(8)
0x75:	product = BRCM 100G 1P 57504 OCP Mezz	(27)
0x91:	part = BCM957504-N1100FXB	(18)
0xa4:	version = 216.2.299.9	(11)
0xb0:	serial = N1100FX19210001YCQ	(18)	***Need to update during manufacturing***
0xc7:	[Product checksum] = ae	(1)		***Need to update during manufacturing***
0xc8:	[OEM Start]
0xcb:	[OEM Record checksum] = 65	(1)	***Need to update during manufacturing***
0xcc:	[OEM Header checksum] = 29	(1)	***Need to update during manufacturing***
0xcd:	manufacturer = 7fa600	(3)
0xd0:	version = 1	(1)
0xd1:	max_pwr_s0 = 18	(1)
0xd2:	max_pwr_s5 = f	(1)
0xd3:	hacct_p = 4	(1)
0xd4:	cacct_p = 2	(1)
0xd5:	card_cooling = 0	(1)
0xd6:	hasar = 2c01	(2)
0xd8:	casar = 7d00	(2)
0xda:	uart_1 = 31	(1)
0xdb:	uart_2 = 0	(1)
0xdc:	usb_present = 0	(1)
0xdd:	manageability_type = 3	(1)
0xde:	write_protection = 18	(1)
0xdf:	pmps = 0	(1)
0xe0:	hacct_a = 6	(1)
0xe1:	cacct_a = 3	(1)
0xe2:	trpl = 4	(1)
0xe3:	trtl = 55	(1)
0xe4:	cttlff = 0	(1)
0xe5:	reserv = ffffffffffffff	(7)
0xec:	number = 1	(1)
0xed:	udid_dev_cap = 0	(1)
0xee:	udid_ver = 8	(1)
0xef:	udid_vid = 14e4	(2)
0xf1:	udid_did = 1751	(2)
0xf3:	udid_interface = 44	(2)
0xf5:	udid_svid = 14e4	(2)
0xf7:	udid_sdid = 5101	(2)
0xf9:	udid_vsid = 0	(4)			***Need to update during manufacturing***
program LSB 4 bytes of base MAC as udid_vsid
0xfd:	[FRU END]

======= Some notes for checksum formula =======
For 1 byte [Board checksum], the formula is (0x00 - SUM([BOARD Start] to ([Board checksum] - 1 )))
For 1 byte [Product checksum], the formula is (0x00 - SUM([Product Start] to ([Product checksum] - 1 )))
For 1 byte [OEM Record checksum], the formula is (0x00 - SUM(([OEM Header checksum] + 1) to ([FRU END] - 1 )))
For 1 byte [OEM Header checksum], the formula is (0x00 - SUM([OEM Start] to [OEM Record checksum]))
[OEM Record checksum] needs to update done before [OEM Header checksum]
