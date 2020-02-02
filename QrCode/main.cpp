#include <stdlib.h>
#include <stdio.h>
#include <SDL/SDL.h>
#include <stdbool.h>
#include <stddef.h>
#include <string.h>
#include "qrcodegen.h"
#include <gtk.h>

/*#include "savepng.h"*/

// Function prototypes
void pause();
static void doSegmentDemo(void);
static void printQr(const uint8_t qrcode[]);

char ch[2];

GtkBuilder *builder;
GtkWidget  *window;
GtkWidget *Gtk_entryName;
GtkWidget *btnConnect;
GtkWidget *lbl_error;
GtkWidget *Gtk_entryMdp;

int main(int argc, char *argv[]){
  	gtk_init(&argc, &argv);
  	doSegmentDemo();
    return EXIT_SUCCESS;
}
void pause()
{
    int continuer = 1;
    SDL_Event event;

    while (continuer)
    {
        SDL_WaitEvent(&event);
        switch(event.type)
        {
            case SDL_QUIT:
                continuer = 0;
        }
    }
}
static void doSegmentDemo(void) {
	{  // Illustration "silver"
		const char *silver0 = "I'm so GOOOOODDDDD HOLYYYYYYYYY patarata 12222222232";
		const char *silver1 = "1v1 sur Fortnite?";
		uint8_t qrcode[qrcodegen_BUFFER_LEN_MAX];
		uint8_t tempBuffer[qrcodegen_BUFFER_LEN_MAX];
		bool ok;
		char *concat;
		{
			/*concat = calloc(strlen(silver0) + strlen(silver1) + 1, sizeof(char));
			strcat(concat, silver0);
			strcat(concat, silver1);*/
			ok = qrcodegen_encodeText(silver0, tempBuffer, qrcode, qrcodegen_Ecc_LOW,
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
    SDL_Surface *ecran = NULL, *rectangle = NULL, *shot = NULL;
    SDL_Rect position;
    SDL_Init(SDL_INIT_VIDEO);

    ecran = SDL_SetVideoMode(1080, 720, 32, SDL_HWSURFACE);
    // Allocation de la surface
    rectangle = SDL_CreateRGBSurface(SDL_HWSURFACE, 15, 15, 32, 0, 0, 0, 0);
   /* rectangle2 = SDL_CreateRGBSurface(SDL_HWSURFACE, 15, 15, 32, 0, 0, 0, 0);*/
    SDL_WM_SetCaption("Ma super fenetre SDL !", NULL);

    SDL_FillRect(ecran, NULL, SDL_MapRGB(ecran->format, 255, 255, 255));

    position.x = 0; // Les coordonnées de la surface seront (0, 0)
    position.y = 0;


	int size = qrcodegen_getSize(qrcode);
	int border = 4;
	sprintf(ch,"%c%c", 219, 219);
	for (int y = -border; y < size + border; y++) {
		for (int x = -border; x < size + border; x++) {
			fputs((qrcodegen_getModule(qrcode, x, y) ? ch : "  "), stdout);
			if(qrcodegen_getModule(qrcode, x, y)){
                SDL_FillRect(rectangle, NULL, SDL_MapRGB(ecran->format, 0, 0, 0));
                SDL_BlitSurface(rectangle, NULL, ecran, &position); // Collage de la surface sur l'écran

                position.x += 15;
			}else{
			        // Remplissage de la surface avec du blanc
                SDL_FillRect(rectangle, NULL, SDL_MapRGB(ecran->format, 255, 255, 255));
                SDL_BlitSurface(rectangle, NULL, ecran, &position); // Collage de la surface sur l'écran

                position.x += 15;
			}
		}
		fputs("\n", stdout);
		position.x = 0;
		position.y += 15;

	}
	fputs("\n", stdout);
	position.x = 0;
    position.y += 15;
    SDL_Flip(ecran); // Mise à jour de l'écran
    SDL_SaveBMP_RW(rectangle, SDL_RWFromFile("qrcode.bmp", "wb"), 1);
   /* SDL_SavePNG_RW(ecran, SDL_RWFromFile("qrcode.png", "wb"), 1); */
   /* shot = SDL_PNGFormatAlpha(ecran);    /* SDL_PNGFormatAlpha is optional, but might be necessary for SCREEN surfaces */
    /*SDL_SavePNG(shot, "screen.png");
    SDL_FreeSurface(shot);
    */

   /* pause();*/

    SDL_FreeSurface(rectangle); // Libération de la surface
/*    SDL_FreeSurface(rectangle2); // Libération de la surface*/

    SDL_Quit();
    builder = gtk_builder_new();
    gtk_builder_add_from_file (builder, "login2-0.glade", NULL);

    window = GTK_WIDGET(gtk_builder_get_object(builder, "windows1"));
    gtk_builder_connect_signals(builder, NULL);

    // get pointers to the two labels
    Gtk_entryName = GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryName"));
    btnConnect = GTK_WIDGET(gtk_builder_get_object(builder, "btnConnect"));
    Gtk_entryMdp = GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryMdp"));
    lbl_error = GTK_WIDGET(gtk_builder_get_object(builder, "lbl_error"));

    gtk_window_set_position(GTK_WINDOW(window), GTK_WIN_POS_CENTER_ALWAYS);

    gtk_builder_connect_signals(builder, NULL);

    g_object_unref(builder);

    /*on affiche notre fenetre (window)*/
    gtk_widget_show(window);
    gtk_main();


}
