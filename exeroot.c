#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>

int main(int argc, char *argv[])
{
if (argc > 0)
{
setuid(0);
system(argv[1]);
return 0;
}
else
return 1;

}
