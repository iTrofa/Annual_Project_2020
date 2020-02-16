#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <dirent.h>

int readFile(FILE* fpsrc, FILE* fpdest);


int main() {
    FILE *fp = NULL;
    FILE *newfp = NULL;
    FILE *crashfp = NULL;
    DIR *dir;
    struct  dirent* ent;
    int count = 0;
    char  path[256];

    dir = opendir("sql/");
    if (!dir)
    {
        crashfp = fopen("crash.log","a");
        fprintf(crashfp, "SQL directory not found\n");
        fclose(crashfp);
        return EXIT_FAILURE;
    }
    newfp = fopen("FINAL.sql","w");
    if (!newfp)
    {
        crashfp = fopen("crash.log","a");
        fprintf(crashfp, "Fusion file couldn't be created\n");
        fclose(crashfp);
        return EXIT_FAILURE;
    }
    fputs("TRUNCATE person;\n",newfp);
    fputs("TRUNCATE client;\n",newfp);
    fputs("TRUNCATE worker;\n",newfp);
    fputs("TRUNCATE log;\n",newfp);
    fputs("TRUNCATE orders;\n",newfp);
    fputs("TRUNCATE service;\n",newfp);
    fputs("TRUNCATE subscription;\n",newfp);

    while ((ent = readdir (dir))!= NULL)
    {
        if (strstr(ent->d_name,".sql")) {
            strcpy(path,"sql/");
            count++;
            strcat(path,ent->d_name);
            puts(path);
            fp = fopen(path,"r");
            if (!fp)
            {
                crashfp = fopen("crash.log","a");
                fprintf(crashfp, "File not found %s \n",ent->d_name);
                fclose(crashfp);
                return EXIT_FAILURE;
            }
            printf("Lines copied %d\n",readFile(fp,newfp));
        }

    }
    printf("Number of SQL files found :%d",count);
    fclose(fp);
    closedir(dir);

    return EXIT_SUCCESS;
}

int readFile(FILE *fpsrc, FILE *fpdest) {
    int count = 0;
    char st[1000];

    while (fgets(st, 1000, fpsrc),feof(fpsrc) ==0 ) {
        if (strstr(st,"insert into")  || strstr(st,"INSERT INTO") ) {
            fputs(st,fpdest);
            count++;
        }
    }
    return count;
}
