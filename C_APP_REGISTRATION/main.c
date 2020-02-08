#include <windows.h>
#include <stdlib.h>
#include <stdio.h>
#include <stdbool.h>
#include <stddef.h>
#include <string.h>
#include "qrcodegen.h"
#include <gtk.h>
#include <SDL/SDL.h>
#include <time.h>
#include <mysql.h>

//Global variables
GtkBuilder *builder;
GtkWidget  *window;
GtkWidget *fixed;
GtkWidget *Gtk_entryName;
GtkWidget *Gtk_entryLastName;
GtkWidget *Gtk_entryPhone;
GtkWidget *Gtk_entryEmail;
GtkWidget *btnGenerate;
GtkWidget *lbl_error;
GtkWidget *Gtk_entryPassword;
GtkWidget *eventbox1;
GtkWidget *eventbox2;

char name[50];
char lastName[50];
char phone[10];
char email[120];
char password[35];
char ch[2];

MYSQL *mysql;
int counter = 0;


//Function Prototypes
G_MODULE_EXPORT void onclickGenerate(GtkButton *button);
static void printQr(const unsigned char qrcode[]);
void done();

int main(int argc, char *argv[]){
    SDL_Init(SDL_INIT_VIDEO);
    freopen( "CON", "w", stdout );
    freopen( "CON", "w", stderr );
    gtk_init(&argc, &argv);
/*  	doSegmentDemo();*/
    builder = gtk_builder_new();
    gtk_builder_add_from_file (builder, "login2-0.glade", NULL);

    /*GdkColor color;
    color.red = 0xFFCC;
    color.green = 0xFFCC;
    color.blue = 0xFFCC;*/

    window = GTK_WIDGET(gtk_builder_get_object(builder, "windows1"));
    fixed  = GTK_WIDGET(gtk_builder_get_object(builder, "fixedLogin"));


  /*gtk_widget_modify_bg(window, GTK_STATE_NORMAL, &color);*/

    gtk_builder_connect_signals(builder, NULL);
    const char path[] = "../logo.png";
    GdkPixbuf *pixbuf = gdk_pixbuf_new_from_file(path, NULL);
    gtk_window_set_icon(GTK_WINDOW(window), pixbuf) ;

    gtk_window_set_icon_from_file(GTK_WINDOW(window), path, NULL);

    // get pointers to the two labels

 /* gtk_widget_modify_bg(Gtk_entryName, GTK_STATE_NORMAL, &color);
    gtk_widget_modify_bg(Gtk_entryMdp, GTK_STATE_NORMAL, &color);
    gtk_widget_modify_bg(eventbox1, GTK_STATE_NORMAL, &color);
    gtk_widget_modify_bg(eventbox2, GTK_STATE_NORMAL, &color);


    color.red = 0x0000;
    color.green = 0x0000;
    color.blue = 0xFFFF;*/

    Gtk_entryName = GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryName"));
    Gtk_entryLastName =  GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryLastName"));
    Gtk_entryPassword = GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryPassword"));
    Gtk_entryEmail = GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryEmail"));
    Gtk_entryPhone = GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryPhone"));
    btnGenerate = GTK_WIDGET(gtk_builder_get_object(builder, "btnGenerate"));
    eventbox1 = GTK_WIDGET(gtk_builder_get_object(builder, "eventbox1"));
    eventbox2 = GTK_WIDGET(gtk_builder_get_object(builder, "eventbox2"));
    lbl_error = GTK_WIDGET(gtk_builder_get_object(builder, "lbl_error"));

    /*gtk_widget_modify_bg(btnConnect, GTK_STATE_NORMAL, &color);*/

    gtk_window_set_position(GTK_WINDOW(window), GTK_WIN_POS_CENTER_ALWAYS);
    gtk_builder_connect_signals(builder, NULL);
    g_object_unref(builder);
    /*on affiche notre fenetre (window)*/


    gtk_widget_show(window);
    gtk_main();
}
void onclickGenerate(GtkButton *button){

    //const gchar* str_text=gtk_label_get_text (GTK_LABEL(lblName));

    /* On stocke le nom et lastName dans la variable Name et LastName*/
     sprintf(name,"%s",gtk_entry_get_text(Gtk_entryName));
     sprintf(lastName,"%s",gtk_entry_get_text(Gtk_entryLastName));
     sprintf(email,"%s",gtk_entry_get_text(Gtk_entryEmail));
     sprintf(phone,"%s",gtk_entry_get_text(Gtk_entryPhone));
     sprintf(password,"%s",gtk_entry_get_text(Gtk_entryPassword));


     /* Une fois qu'on a stocker les infos de login dans les variables tout est possible
     (je parle bien sur de l'insertion ou la verification dans la bdd)*/

     printf("\n---Info Connexion :");
     printf("\n--User Info : %s",name);
     printf("\n--User Info : %s",lastName);
     printf("\n--User Info : %s",email);
     printf("\n--User Info : %s",phone);
     printf("\n--User Info : %s\n",password);


    	{  // Illustration "silver"
		const char *silver0 = name;
		const char *silver1 = lastName;
		const char *silver2 = email;
		const char *silver3 = phone;
		const char *silver4 = password;
		unsigned char qrcode[qrcodegen_BUFFER_LEN_MAX];
		unsigned char tempBuffer[qrcodegen_BUFFER_LEN_MAX];
		bool ok;
		char *concat;
		{
			concat = calloc(strlen(silver0) + strlen(silver1) + strlen(silver2) + strlen(silver3) + strlen(silver4) + 4, sizeof(char));
			strcat(concat, silver0);
			strcat(concat, silver1);
			strcat(concat, silver2);
			strcat(concat, silver3);
			strcat(concat, silver4);

			ok = qrcodegen_encodeText(concat, tempBuffer, qrcode, qrcodegen_Ecc_LOW,
				qrcodegen_VERSION_MIN, qrcodegen_VERSION_MAX, qrcodegen_Mask_AUTO, true);
			if (ok)
				printQr(qrcode);
			free(concat);
		}
		}


}



// Prints the given QR Code to the console.
static void printQr(const unsigned char qrcode[]){
    if(counter == 1){
    done();
    }else{
    SDL_Surface *ecran = NULL, *rectangle = NULL, *shot = NULL;
    SDL_Rect position;
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
    SDL_SaveBMP_RW(ecran, SDL_RWFromFile("qrcode.bmp", "wb"), 1);
   /* SDL_SavePNG_RW(ecran, SDL_RWFromFile("qrcode.png", "wb"), 1); */
   /* shot = SDL_PNGFormatAlpha(ecran);    /* SDL_PNGFormatAlpha is optional, but might be necessary for SCREEN surfaces */
    /*SDL_SavePNG(shot, "screen.png");
    SDL_FreeSurface(shot);
    */

   /* pause();*/

    SDL_FreeSurface(rectangle); // Libération de la surface

/*    SDL_FreeSurface(rectangle2); // Libération de la surface*/
    SDL_Quit();

    /*Vérification log_in SQL*/

    mysql = mysql_init(NULL);
    mysql_options(mysql,MYSQL_READ_DEFAULT_GROUP,"option");
    if(mysql_real_connect(mysql,"localhost","root","root","C_PROJECT",3308,NULL,0)) {
        /*sprintf(sql_cmd,"INSERT INTO user(username, password) VALUES ('%s', '%s')", UserPseudo, UserMdp);
        printf("%s\n", sql_cmd);*/
        counter = 1;
       /* if(mysql_query(mysql, sql_cmd)){
            printf("\nThat username is already taken, choose another!\n");
            gtk_label_set_text(lbl_error, "That username is already taken, choose another!");
        }else{
            printf("You did it");
            counter = 1;
        }*/
    } else{
        printf("\nConnection Error !");
     }
    }
}
void done(){
    printf("DONE");
    SDL_Quit();
}
