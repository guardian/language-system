# The Multi-Language Automatic Translation, Subtitling, and Voice Rendering System

A system that uses third party software to automatically convert audio to text, translate text, render text to video, and render text to audio.

**Requirements**

- [Linux](https://www.linux.org/)
- [Apache HTTP Server](https://httpd.apache.org/)
- [PHP](https://php.net/)
- [MySQL Server](https://www.mysql.com/)
- [FFmpeg](https://ffmpeg.org/)
- [Autosub](https://github.com/agermanidis/autosub)
- [eSpeak](http://espeak.sourceforge.net/)
- [Composer](https://getcomposer.org/)
- [Google Translate PHP](https://github.com/Stichoza/google-translate-php)
- [Plupload](https://www.plupload.com/)
- A World Wide Web browser

**Requirements for Optional Elements**

- macOS
- AWS SDK for PHP
- An Amazon Web Services account

**Functions**

1. Transcribe a subtitle file from a video or audio file in around seventy languages. Currently it supports MP3, MP4, MPG, MXF, MOV, AIFF, and WAV files.
2. Translate subtitle files from one language to another in around seventy languages.
3. Machine speech rendering to video or audio with pronunciation dictionaries for around fifty languages.
4. Subtitle rendering to video with support for about twenty writing systems.
5. Allows the user to upload subtitle files in the SRT format for use with the system.

**Installation and Set Up**

1. Install [Linux](https://www.linux.org/).

2. Install [Apache HTTP Server](https://httpd.apache.org/).

3. Install [PHP](https://php.net/).

4. Install [MySQL Server](https://www.mysql.com/).

5. Install [FFmpeg](https://ffmpeg.org/).

6. Install [Autosub](https://github.com/agermanidis/autosub).
  - Run `pip install autosub`

7. Install [eSpeak](http://espeak.sourceforge.net/).

8. Install [Composer](https://getcomposer.org/download/).

9. Install [Google Translate PHP](https://github.com/Stichoza/google-translate-php).

10. Install [Plupload](https://www.plupload.com/).

11. Clone the Git repository of Language System to a folder that is served by Apache HTTP Server.

12. Create a MySQL user for Language System to use.

13. Create a MySQL schema called 'language_system' and give the user you just made full access to it.

14. Install the database SQL files from the database folder.

15. Set the following environment variables to be read by Apache HTTP Server. On openSUSE the file to do this in is /usr/lib/systemd/system/apache2.service in the Service block.
  - DATABASE_HOST=localhost
    Where localhost is the host name of your database server.
  - DATABASE_USER=ls
    Where ls is the user name for the MySQL account for Language System to use.
  - DATABASE_PASSWORD=langsyspass
    Where langsyspass is the password for the MySQL account for Language System to use.
  - LANGUAGE_UPLOADS=uploads
    Where uploads is the path to the folder for media files to be stored relative to the folder you installed Language System in.
  - LANGUAGE_RENDERS=renders
    Where renders is the path to the folder for renders to be stored relative to the folder you installed Language System in.
  - LANGUAGE_THUMBNAILS=thumbnails
    Where thumbnails is the path to the folder for thumbnails to be stored relative to the folder you installed Language System in.
  - LANGUAGE_SUBTITLES=subtitles
    Where subtitles is the path to the folder for subtitles to be stored relative to the folder you installed Language System in.
  - LANGUAGE_WORKING=working
    Where working is the path to the folder for Language System to use as a working folder relative to the folder you installed Language System in.
  - LANGUAGE_JSON=json
    Where json is the path to the folder for JSON files to be stored relative to the folder you installed Language System in.
  - LANGUAGE_TEXT=text
    Where text is the path to the folder for text files to be stored relative to the folder you installed Language System in.
  - LANGUAGE_FFMPEG=ffmpeg
    Where ffmpeg is the path to your FFmpeg executable.
  - LANGUAGE_AWS_REGION=eu-west-1
    Where eu-west-1 is the AWS region you want to do your AWS processing in. Can be ignored if you are not using AWS.
  - LANGUAGE_AWS_BUCKET=bucket-name
    Where bucket-name is the S3 bucket you want to do your AWS processing in. Can be ignored if you are not using AWS.

16. Make sure all the folders you just told the system to use with environment variables exist and are readable and writeable by the user Apache HTTP Server runs as.

17. Start or restart Apache HTTP Server so it can load the environment variables.
