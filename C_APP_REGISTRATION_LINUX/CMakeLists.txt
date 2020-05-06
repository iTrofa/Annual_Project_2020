cmake_minimum_required(VERSION 3.16) 
# Set the name and the supported language of the project
        PROJECT(registration_app C)
        # Set the minimum version of cmake required to build this project
        set(CMAKE_C_STANDARD 99)
set(CMAKE_C_FLAGS "${CMAKE_C_FLAGS} -rdynamic")
set(CMAKE_MODULE_PATH ${CMAKE_MODULE_PATH} ${registration_app_SOURCE_DIR}/cmake)
        find_package(SDL REQUIRED)
        find_package(MYSQL REQUIRED)
        find_package(sodium REQUIRED)
        # Use the package PkgConfig to detect GTK+ headers/library files

        include(FindPkgConfig)
        PKG_CHECK_MODULES(GTK3 REQUIRED gtk+-3.0)


# Setup CMake to use GTK+, tell the compiler where to look for headers
        # and to the linker where to look for libraries
        INCLUDE_DIRECTORIES(${GTK3_INCLUDE_DIRS})
        INCLUDE_DIRECTORIES(${sodium_INCLUDE_DIR})
        INCLUDE_DIRECTORIES(${LIBPNG_INCLUDE_DIRS})
        INCLUDE_DIRECTORIES(${SDL_INCLUDE_DIRS})
        INCLUDE_DIRECTORIES(${MYSQL_INCLUDE_DIRS})

        # Add other flags to the compiler
        ADD_DEFINITIONS(${GTK3_CFLAGS_OTHER})

        # Add an executable compiled from hello.c
        ADD_EXECUTABLE(registration_app main.c qrcodegen.c savepng.c)

        # Link the target to the GTK+ libraries

        TARGET_LINK_LIBRARIES(registration_app sodium ${GTK3_LIBRARIES} ${SDL_LIBRARY} ${MYSQL_LIB} ${LIBPNG_LIBRARIES} -lpng)
