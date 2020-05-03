#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <dirent.h>
#include <mysql.h>
#include <stdbool.h>

int readFile(FILE* fpsrc, FILE* fpdest, MYSQL* mysql, FILE* conflict);
bool testInsert(MYSQL* mysql, char* query, char* error);

int main() {
    FILE *fp = NULL;
    FILE *newfp = NULL;
    FILE* conflictfile = NULL;
    FILE *crashfp = NULL;
    DIR *dir = NULL;
    struct  dirent* ent;
    MYSQL* mysql ;
    int count = 0;
    char  path[256];

    mysql = mysql_init(NULL);
    mysql_options(mysql,MYSQL_READ_DEFAULT_GROUP,"option");
    if(!mysql_real_connect(mysql,"localhost","admin","password",
                           "flashAssistance",3306,NULL,0))
    {
        crashfp = fopen("../crash.log","a");
        fputs("error credential or server\n",crashfp);
        fclose(crashfp);
        return EXIT_FAILURE;
    }
    mysql_query(mysql,"SET FOREIGN_KEY_CHECKS=0;");
    dir = opendir("../sql/");
    if (!dir)
    {
        crashfp = fopen("../crash.log","a");
        fprintf(crashfp, "folder sql not found\n");
        fclose(crashfp);
        return EXIT_FAILURE;
    }
    newfp = fopen("../new.sql","a");
    if (!newfp)
    {
        crashfp = fopen("../crash.log","a");
        fprintf(crashfp, "merge file impossible to be ceate\n");
        fclose(crashfp);
        return EXIT_FAILURE;
    }
    conflictfile = fopen("../conflict.txt","wb");
    if (!conflictfile)
    {
        crashfp = fopen("../crash.log","a");
        fputs("conflict file impossible to be create\n",crashfp);
        fclose(crashfp);
        return EXIT_FAILURE;
    }
    while ((ent = readdir (dir))!= NULL)
    {
        if (strstr(ent->d_name,".sql")) {
            strcpy(path,"../sql/");
            count++;
            strcat(path,ent->d_name);
            fp = fopen(path,"r");
            if (!fp)
            {
                crashfp = fopen("../crash.log","a");
                fprintf(crashfp, "file not opnable %s \n",ent->d_name);
                fclose(crashfp);
                return EXIT_FAILURE;
            }
            printf("line copied %d\n",readFile(fp,newfp,mysql,conflictfile));
        }

    }
    mysql_query(mysql,"SET FOREIGN_KEY_CHECKS=1;");
    mysql_close(mysql);
    fclose(fp);
    closedir(dir);
    printf("number of file found:%d",count);
    return EXIT_SUCCESS;
}

int readFile(FILE *fpsrc, FILE *fpdest, MYSQL* mysql, FILE* fpconflict) {
    int count = 0;
    char initial_query[600];
    char error[255];

    while (fgets(initial_query, 600, fpsrc))
    {
        if (strstr(initial_query, "INSERT INTO") || strstr(initial_query, "insert into")) {

            if (testInsert(mysql, initial_query, error) == true) {
                puts("insert successfull");
                fputs(initial_query, fpdest);
                count++;
            } else {
                fputs("adding the conflict line in conflict.txt\n",stderr);
                fwrite(&initial_query,sizeof(char),strlen(initial_query),fpconflict);
            }
        }
    }
    return count;
}
bool testInsert(MYSQL *mysql, char *query, char* error) {
    if(mysql_query(mysql,query)!= 0){
        fputs("query can't be insert\n",stderr);
        strcpy(error,mysql_error(mysql));
        return false;
    }
    return true;
}