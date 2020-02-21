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
#include "savepng.h"

//Global variables
GtkBuilder *builder;
GtkWidget  *window;
GtkWidget *fixed;
GtkWidget *Gtk_entryName;
GtkWidget *Gtk_entryLastName;
GtkWidget *Gtk_entryPhone;
GtkWidget *Gtk_entryFunction;
GtkWidget *Gtk_entryLocalisation;
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
char fonction[50];
char localisation[50];
char ch[2];
char sql_qry[250];

MYSQL *mysql;
int counter = 0;


//Function Prototypes
G_MODULE_EXPORT void onclickGenerate(GtkButton *button);
static void printQr(const unsigned char qrcode[]);
void done();
void uuid(char*);
int checkLocalisation(char *);

int main(int argc, char *argv[]){
    srand(time(NULL));
    SDL_Init(SDL_INIT_VIDEO);
    freopen( "CON", "w", stdout );
    freopen( "CON", "w", stderr );
    gtk_init(&argc, &argv);
/*  	doSegmentDemo();*/
    builder = gtk_builder_new();
    gtk_builder_add_from_file (builder, "login3-0.glade", NULL);

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
    Gtk_entryFunction = GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryFunction"));
    Gtk_entryLocalisation = GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryLocalisation"));
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
    char newerror[100];
    int verification = 0;
    int errorlbl = 0;
    //const gchar* str_text=gtk_label_get_text (GTK_LABEL(lblName));

    /* On stocke le nom et lastName dans la variable Name et LastName*/
     sprintf(name,"%s",gtk_entry_get_text(Gtk_entryName));
     sprintf(lastName,"%s",gtk_entry_get_text(Gtk_entryLastName));
     sprintf(email,"%s",gtk_entry_get_text(Gtk_entryEmail));
     sprintf(phone,"%s",gtk_entry_get_text(Gtk_entryPhone));
     sprintf(password,"%s",gtk_entry_get_text(Gtk_entryPassword));
     sprintf(fonction,"%s",gtk_entry_get_text(Gtk_entryFunction));
     sprintf(localisation,"%s",gtk_entry_get_text(Gtk_entryLocalisation));



     /* Une fois qu'on a stocker les infos de login dans les variables tout est possible
     (je parle bien sur de l'insertion ou la verification dans la bdd)*/

     printf("\n---Info Connexion :");
     printf("\n--User Info : %s",name);
     printf("\n--User Info : %s",lastName);
     printf("\n--User Info : %s",email);
     printf("\n--User Info : %s",phone);
     printf("\n--User Info : %s\n",password);
     printf("\n--User Info : %s\n",fonction);
     printf("\n--User Info : %s\n",localisation);

     if(strcmp(name, "") == 0 || strcmp(lastName, "") == 0 || strcmp(email, "") == 0 || strcmp(phone, "") == 0 || strcmp(password, "") == 0 || strcmp(fonction, "") == 0 || strcmp(localisation, "") == 0){
        printf("Error");
        errorlbl = 1;
        gtk_label_set_text(lbl_error, "Please Fill in all the inputs !\n");
     }
    if(errorlbl == 0){
    if(checkLocalisation(localisation) == 0){
        verification = 1;
    }
    else{
        if(errorlbl == 0){
        printf("Out: %d", strcmpi(localisation, "Paris"));
        gtk_label_get_text(lbl_error);
        sprintf(newerror, "Choose the nearest city: Paris, Marseille, Tours, Rennes or Nantes !");
        gtk_label_set_text(lbl_error, newerror);
        }else if(errorlbl == 1){
        gtk_label_get_text(lbl_error);
        sprintf(newerror, "%s Choose the nearest city: Paris, Marseille, Tours, Rennes or Nantes !", gtk_label_get_text(lbl_error));
        gtk_label_set_text(lbl_error, newerror);
        }
        }
    }
    if(verification == 1){
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
}



// Prints the given QR Code to the console.
static void printQr(const unsigned char qrcode[]){
    char *uuid2[40];
    char *uuid3[40];

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
    shot = SDL_PNGFormatAlpha(ecran);    /* SDL_PNGFormatAlpha is optional, but might be necessary for SCREEN surfaces */
    SDL_SavePNG(shot, "qrcode.png");
    SDL_FreeSurface(shot);


    SDL_FreeSurface(rectangle); // Libération de la surface

    SDL_Quit();

    /*Vérification log_in SQL*/

    mysql = mysql_init(NULL);
    mysql_options(mysql,MYSQL_READ_DEFAULT_GROUP,"option");
    if(mysql_real_connect(mysql,"localhost","root","","flashassistance",3308,NULL,0)) {
        uuid(uuid2);
        sprintf(sql_qry,"INSERT INTO person(firstName, lastName, email, phoneNumber, password, idPerson, function, localisation) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", name, lastName, email, phone, password, uuid2, fonction, localisation);
        printf("%s\n", sql_qry);

        if(mysql_query(mysql, sql_qry)){
            printf("\error MySQL!\n");
            gtk_label_set_text(lbl_error, "There was an error with the Server!");
        }else{
            printf("You did it");
            uuid(uuid3);
            sprintf(sql_qry,"INSERT INTO worker(idWorker, qrCode, idPerson) VALUES ('%s', '%s', '%s')", uuid3, "qrcode.bmp", uuid2);
            printf("%s\n", sql_qry);
             if(mysql_query(mysql, sql_qry)){
                printf("\Error MySQL!\n");
                gtk_label_set_text(lbl_error, "There was an error with the Server!");
             }else{
                counter = 1;
                printf("\nYou did it x2");
             }
        }
    }else{
        printf("\nConnection Error !");
     }
    done();
}
void done(){
    printf("DONE !");
    gtk_entry_set_text(Gtk_entryName, "");
    gtk_entry_set_text(Gtk_entryLastName, "");
    gtk_entry_set_text(Gtk_entryEmail, "");
    gtk_entry_set_text(Gtk_entryPhone, "");
    gtk_entry_set_text(Gtk_entryPassword, "");
    gtk_entry_set_text(Gtk_entryFunction, "");
    gtk_entry_set_text(Gtk_entryLocalisation, "");
    gtk_label_set_text(lbl_error, "REGISTRATION COMPLETED AND SAVED");
    GdkColor color;
    color.red = 0x0000;
    color.green = 0xFFFF;
    color.blue = 0x0000;
    gtk_widget_modify_bg(eventbox2, GTK_STATE_NORMAL, &color);
}
void uuid(char *uuid){
    const char *hex_digits = "0123456789ABCDEF";
    /*printf("%llu",strlen("f4e59137-7c8a-4c80-9f50-b0a962e4309b"));*/
    sprintf( uuid,"%04x%04x-%04x-%04x-%04x-%04x%04x%04x",
            // 32 bits for "time_low"
                  rand() % 0xffff , rand() % 0xffff ,

            // 16 bits for "time_mid"
              rand() %0xffff ,

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
              rand() % 0x0fff | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
              rand() % 0x3fff  | 0x8000,

            // 48 bits for "node"
             rand() % 0xffff ,rand() % 0xffff ,rand() % 0xffff );
     printf("%s\n", uuid);
}
int checkLocalisation(char *localisation){

        if(strcmpi(localisation, "Paris") == 0 || strcmpi(localisation, "Marseille") == 0 || strcmpi(localisation, "Tours") == 0 || strcmpi(localisation, "Rennes") == 0 || strcmpi(localisation, "Nantes") == 0){
        printf("In %d \n", strcmpi(localisation, "Paris"));
        printf("You're in !");
        if(strcmpi(localisation, "Paris") == 0){
                strcpy(localisation, "Paris");
        }else if(strcmpi(localisation, "Marseille") == 0){
                strcpy(localisation, "Marseille");
        }else if(strcmpi(localisation, "Tours") == 0){
                strcpy(localisation, "Tours");
        }else if(strcmpi(localisation, "Rennes") == 0){
                strcpy(localisation, "Rennes");
        }else if(strcmpi(localisation, "Nantes") == 0){
                strcpy(localisation, "Nantes");
        }
        return 0;
        }else{
        return 1;
        }
}
