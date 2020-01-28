/*
 * QR Code generator demo (C)
 *
 * Run this command-line program with no arguments. The program
 * computes a demonstration QR Codes and print it to the console.
 *
 * Copyright (c) Project Nayuki. (MIT License)
 * https://www.nayuki.io/page/qr-code-generator-library
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * - The above copyright notice and this permission notice shall be included in
 *   all copies or substantial portions of the Software.
 * - The Software is provided "as is", without warranty of any kind, express or
 *   implied, including but not limited to the warranties of merchantability,
 *   fitness for a particular purpose and noninfringement. In no event shall the
 *   authors or copyright holders be liable for any claim, damages or other
 *   liability, whether in an action of contract, tort or otherwise, arising from,
 *   out of or in connection with the Software or the use or other dealings in the
 *   Software.
 */

#include <stdbool.h>
#include <stddef.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "qrcodegen.h"


// Function prototypes
/*static void doBasicDemo(void);
static void doVarietyDemo(void);*/
static void doSegmentDemo(void);
/*static void doMaskDemo(void);*/
static void printQr(const uint8_t qrcode[]);

char ch[2];

// The main application program.
int main(void) {
	/*doBasicDemo();
	doVarietyDemo();*/
	doSegmentDemo();
	/*doMaskDemo();*/
	system("pause");
	return EXIT_SUCCESS;
}
// Creates QR Codes with manually specified segments for better compactness.
static void doSegmentDemo(void) {
	{  // Illustration "silver"
		const char *silver0 = "Bonjour Thomas";
		const char *silver1 = "1v1 sur Fortnite?";
		uint8_t qrcode[qrcodegen_BUFFER_LEN_MAX];
		uint8_t tempBuffer[qrcodegen_BUFFER_LEN_MAX];
		bool ok;
		{
			char *concat = calloc(strlen(silver0) + strlen(silver1) + 1, sizeof(char));
			strcat(concat, silver0);
			strcat(concat, silver1);
			ok = qrcodegen_encodeText(concat, tempBuffer, qrcode, qrcodegen_Ecc_LOW,
				qrcodegen_VERSION_MIN, qrcodegen_VERSION_MAX, qrcodegen_Mask_AUTO, true);
			if (ok)
				printQr(qrcode);
			free(concat);
		}
		}
	}

/*---- Utilities ----*/

// Prints the given QR Code to the console.
static void printQr(const uint8_t qrcode[]) {
	int size = qrcodegen_getSize(qrcode);
	int border = 4;
	sprintf(ch,"%c%c", 219, 219);
	for (int y = -border; y < size + border; y++) {
		for (int x = -border; x < size + border; x++) {
			fputs((qrcodegen_getModule(qrcode, x, y) ? ch : "  "), stdout);
		}
		fputs("\n", stdout);
	}
	fputs("\n", stdout);
}
