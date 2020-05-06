#include <stdlib.h>
#include <stdio.h>
#include <stdbool.h>
#include <stddef.h>
#include <string.h>
#include "qrcodegen.h"
#include <gtk/gtk.h>
#include <SDL/SDL.h>
#include <time.h>
#include <mysql/mysql.h>
#include "savepng.h"
#include <ctype.h>
#include <sodium.h>
//Global variables
GtkBuilder *builder;
GtkWidget  *window;
GtkWidget *fixed;
GtkEntry *Gtk_entryName;
GtkEntry *Gtk_entryLastName;
GtkEntry *Gtk_entryPhone;
GtkEntry *Gtk_entryFunction;
GtkEntry *Gtk_entryLocalisation;
GtkEntry *Gtk_entryEmail;
GtkWidget *btnGenerate;
GtkWidget *lbl_error;
GtkEntry *Gtk_entryPassword;
GtkWidget *eventbox1;
GtkWidget *eventbox2;

char name[50];
char lastName[50];
char phone[10];
char email[120];
char password[35];
char fonction[50];
char localisation[50];
char sql_qry[400];

MYSQL *mysql;

typedef struct dbInfo{
    char host[30];
    char name[30];
    char login[30];
    char password[30];
    int port;
}dbInfo;

//Function Prototypes
G_MODULE_EXPORT void onclickGenerate(GtkButton *button);
static void printQr(const unsigned char qrcode[]);
void add_database();
void change_label(char*);
void reset_label();
void uuid(char*);
bool checkLocalisation(char *);
bool checkName(char*);
void hashPassword(char* password,char* hashed );
void readConfig(dbInfo* db);
char* getSecondWord(char* str);
int main(int argc, char *argv[])
{
    srand(time(NULL));
    SDL_Init(SDL_INIT_VIDEO);
    gtk_init(&argc, &argv);
    /*  	doSegmentDemo();*/
    builder = gtk_builder_new();
    gtk_builder_add_from_file (builder, "../login3-0.glade", NULL);


    window = GTK_WIDGET(gtk_builder_get_object(builder, "windows1"));

    g_signal_connect(window, "destroy", G_CALLBACK(gtk_main_quit), NULL);

    fixed  = GTK_WIDGET(gtk_builder_get_object(builder, "fixedLogin"));




    gtk_builder_connect_signals(builder, NULL);
    const char path[] = "../logo.png";
    GdkPixbuf *pixbuf = gdk_pixbuf_new_from_file(path, NULL);
    gtk_window_set_icon_from_file(GTK_WINDOW(window), path, NULL);
    gtk_window_set_icon(GTK_WINDOW(window), pixbuf) ;


    // get pointers to the two labels

    Gtk_entryName =(GtkEntry*) GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryName"));
    Gtk_entryLastName =(GtkEntry*)  GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryLastName"));
    Gtk_entryPassword =(GtkEntry*) GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryPassword"));
    Gtk_entryEmail = (GtkEntry*) GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryEmail"));
    Gtk_entryPhone = (GtkEntry*) GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryPhone"));
    Gtk_entryFunction =(GtkEntry*) GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryFunction"));
    Gtk_entryLocalisation = (GtkEntry*) GTK_WIDGET(gtk_builder_get_object(builder, "Gtk_entryLocalisation"));
    btnGenerate = GTK_WIDGET(gtk_builder_get_object(builder, "btnGenerate"));
    eventbox1 = GTK_WIDGET(gtk_builder_get_object(builder, "eventbox1"));
    eventbox2 = GTK_WIDGET(gtk_builder_get_object(builder, "eventbox2"));
    lbl_error = GTK_WIDGET(gtk_builder_get_object(builder, "lbl_error"));


    //gtk_window_set_position(GTK_WINDOW(window), GTK_WIN_POS_CENTER_ALWAYS);
    gtk_builder_connect_signals(builder, NULL);
    g_object_unref(builder);
    /*on affiche notre fenetre (window)*/

    if(window == NULL)
    {
        fputs("error windows null",stderr);
        exit(1);
    }
    gtk_widget_show(window);

    gtk_main();
}
void onclickGenerate(GtkButton *button)
{

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


    if(strcmp(name, "") == 0 || strcmp(lastName, "") == 0 || strcmp(email, "") == 0 || strcmp(phone, "") == 0 || strcmp(password, "") == 0 || strcmp(fonction, "") == 0 || strcmp(localisation, "") == 0)
    {

        change_label("Please Fill in all the inputs !\n");
        return;
    }
    if(strstr(email,"@")== NULL)
    {
        change_label("Insert a valid Email !\n");
        return;
    }
    if(checkName(name) == false || checkName(lastName) == false)
    {
         change_label("Only alphanumeric values are allowed in Name/LastName !");
         return;
    }
    if(!checkLocalisation(localisation) == true )
    {
        change_label("Choose the nearest city: Paris, Marseille, Tours, Rennes or Nantes !");
        return;
    }

    // Illustration "silver"
    const char *silver0 = name;
    const char *silver1 = lastName;
    const char *silver2 = email;
    const char *silver3 = phone;
    unsigned char qrcode[qrcodegen_BUFFER_LEN_MAX];
    unsigned char tempBuffer[qrcodegen_BUFFER_LEN_MAX];
    bool ok;
    char *concat;

        concat = malloc((strlen(silver0) + strlen(silver1) + strlen(silver2) + strlen(silver3) + 3 )* sizeof(char));
        strcat(concat, silver0);
        strcat(concat, silver1);
        strcat(concat, silver2);
        strcat(concat, silver3);

        ok = qrcodegen_encodeText(concat, tempBuffer, qrcode, qrcodegen_Ecc_LOW,
                                  qrcodegen_VERSION_MIN, qrcodegen_VERSION_MAX, qrcodegen_Mask_AUTO, true);
        if (ok)
            printQr(qrcode);
        free(concat);
}



// Prints the given QR Code to the SDL window.
static void printQr(const unsigned char qrcode[])
{
    SDL_Surface *ecran = NULL, *rectangle = NULL, *shot = NULL;
    SDL_Rect position;
    ecran = SDL_SetVideoMode(1080, 720, 32, SDL_HWSURFACE);
    // Allocation de la surface
    rectangle = SDL_CreateRGBSurface(SDL_HWSURFACE, 15, 15, 32, 0, 0, 0, 0);

    SDL_FillRect(ecran, NULL, SDL_MapRGB(ecran->format, 255, 255, 255));

    position.x = 0; // Les coordonnées de la surface seront (0, 0)
    position.y = 0;

    int size = qrcodegen_getSize(qrcode);
    int border = 4;
    for (int y = -border; y < size + border; y++)
    {
        for (int x = -border; x < size + border; x++)
        {
            if(qrcodegen_getModule(qrcode, x, y))
            {
                SDL_FillRect(rectangle, NULL, SDL_MapRGB(ecran->format, 0, 0, 0));
                SDL_BlitSurface(rectangle, NULL, ecran, &position); // Collage de la surface sur l'écran

                position.x += 15;
            }
            else
            {
                // Remplissage de la surface avec du blanc
                SDL_FillRect(rectangle, NULL, SDL_MapRGB(ecran->format, 255, 255, 255));
                SDL_BlitSurface(rectangle, NULL, ecran, &position); // Collage de la surface sur l'écran

                position.x += 15;
            }
        }
        position.x = 0;
        position.y += 15;
    }
    position.x = 0;
    position.y += 15;
    SDL_Flip(ecran); // Mise à jour de l'écran
    shot = SDL_PNGFormatAlpha(ecran);    /* SDL_PNGFormatAlpha is optional, but might be necessary for SCREEN surfaces */
    SDL_SavePNG(shot, "qrcode.png");
    SDL_FreeSurface(shot);

    SDL_FreeSurface(rectangle); // Libération de la surface

    SDL_Quit();

    add_database();
}
void reset_label()
{
    gtk_entry_set_text(Gtk_entryName, "");
    gtk_entry_set_text(Gtk_entryLastName, "");
    gtk_entry_set_text(Gtk_entryEmail, "");
    gtk_entry_set_text(Gtk_entryPhone, "");
    gtk_entry_set_text(Gtk_entryPassword, "");
    gtk_entry_set_text(Gtk_entryFunction, "");
    gtk_entry_set_text(Gtk_entryLocalisation, "");
    change_label("REGISTRATION COMPLETED AND SAVED");
}
void uuid(char *uuid)
{
    const char *hex_digits = "0123456789ABCDEF";
    sprintf( uuid,"%04x%04x-%04x-%04x-%04x-%04x%04x%04x",
             // 32 bits for "time_low"
             rand() % 0xffff, rand() % 0xffff,

             // 16 bits for "time_mid"
             rand() %0xffff,

             // 16 bits for "time_hi_and_version",
             // four most significant bits holds version number 4
             rand() % 0x0fff | 0x4000,

             // 16 bits, 8 bits for "clk_seq_hi_res",
             // 8 bits for "clk_seq_low",
             // two most significant bits holds zero and one for variant DCE1.1
             rand() % 0x3fff  | 0x8000,

             // 48 bits for "node"
             rand() % 0xffff,rand() % 0xffff,rand() % 0xffff );
}
bool checkLocalisation(char *localisation)
{
#ifdef _WIN32

    if(strcmpi(localisation, "Paris") == 0 || strcmpi(localisation, "Marseille") == 0 || strcmpi(localisation, "Tours") == 0 || strcmpi(localisation, "Rennes") == 0 || strcmpi(localisation, "Nantes") == 0)
    {
        if(strcmpi(localisation, "Paris") == 0)
        {
            strcpy(localisation, "Paris");
        }
        else if(strcmpi(localisation, "Marseille") == 0)
        {
            strcpy(localisation, "Marseille");
        }
        else if(strcmpi(localisation, "Tours") == 0)
        {
            strcpy(localisation, "Tours");
        }
        else if(strcmpi(localisation, "Rennes") == 0)
        {
            strcpy(localisation, "Rennes");
        }
        else if(strcmpi(localisation, "Nantes") == 0)
        {
            strcpy(localisation, "Nantes");
        }
        return true;
    }
#else
    if(strcasecmp(localisation, "Paris") == 0 || strcasecmp(localisation, "Marseille") == 0 || strcasecmp(localisation, "Tours") == 0
    || strcasecmp(localisation, "Rennes") == 0 || strcasecmp(localisation, "Nantes") == 0)
    {
        if(strcasecmp(localisation, "Paris") == 0)
        {
            strcpy(localisation, "Paris");
        }
        else if(strcasecmp(localisation, "Marseille") == 0)
        {
            strcpy(localisation, "Marseille");
        }
        else if(strcasecmp(localisation, "Tours") == 0)
        {
            strcpy(localisation, "Tours");
        }
        else if(strcasecmp(localisation, "Rennes") == 0)
        {
            strcpy(localisation, "Rennes");
        }
        else if(strcasecmp(localisation, "Nantes") == 0)
        {
            strcpy(localisation, "Nantes");
        }
        return true;
    }
#endif
    else
    {
        return false;
    }
}

void add_database() {
    char uuid2[40];
    char hashed_password[crypto_pwhash_STRBYTES];
    dbInfo db;
    mysql = mysql_init(NULL);
    mysql_options(mysql, MYSQL_READ_DEFAULT_GROUP, "option");

    readConfig(&db);
    if (!db.port) {
        change_label("credential error");
    }
        if (mysql_real_connect(mysql, db.host, db.login, db.password,
                                      db.name, db.port, NULL, 0)) {
            uuid(uuid2);
            hashPassword(password, hashed_password);
            sprintf(sql_qry,
                    "INSERT INTO person(firstName, lastName, email, phoneNumber, password, idPerson, function, localisation, qrCode) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                    name, lastName, email, phone, hashed_password, uuid2, fonction, localisation, "qrcode.png");

            if (mysql_query(mysql, sql_qry)) {
                fprintf(stderr, "error MySQL! %s\n", mysql_error(mysql));
                change_label(" There was an error with the Server!");
            }
        } else {
            fprintf(stderr, "\nConnection Error !\n %s", mysql_error(mysql));
            change_label("Database or credentials file error !");
            return;
        }
        mysql_close(mysql);
        reset_label();
    }

void change_label(char* message)
{
        gtk_label_set_text((GtkLabel *) lbl_error, message);
}

bool checkName(char* names){
    for(int i = 0; i<strlen(names); i++)
    {
        if(isalpha(names[i]) == 0){
                return false;
        }
    }
    return true;
}

void hashPassword(char *password,char* hashed) {
    if (sodium_init()<0){
        change_label("sodium is not available");
        fputs("sodium is not available",stderr);
        exit(1);
    }
    if (crypto_pwhash_str(hashed, password, strlen(password),
                          crypto_pwhash_OPSLIMIT_SENSITIVE, crypto_pwhash_MEMLIMIT_SENSITIVE) != 0) {
        change_label("sodium doesn't work");
        fputs("can't hash for the momment not enough memory",stderr);
    }

}
 void readConfig(dbInfo* db){
    char *tmp;
    FILE * config;
    tmp = malloc(sizeof(char)*100);

    config = fopen("../config.db","r");
    if (config == NULL)
        return;
    fgets(tmp,100,config);
     strcpy(db->name,getSecondWord(tmp));
    db->name[strlen(db->name) -1] = '\0';

    fgets(tmp,30,config);
     strcpy(db->login,getSecondWord(tmp));
     db->login[strlen(db->login) -1] = '\0';

    fgets(tmp,30,config);
     strcpy(db->password,getSecondWord(tmp));
     db->password[strlen(db->password) -1] = '\0';

     fgets(tmp,30,config);
     strcpy(db->host,getSecondWord(tmp));
     db->host[strlen(db->host) -1] = '\0';

    fgets(tmp,30,config);
    db->port =(int)strtol(getSecondWord(tmp),NULL,10);
    fclose(config);

}

char* getSecondWord(char* str){
    char *token = strtok(str, " ");
    return strtok(NULL, " ");
}