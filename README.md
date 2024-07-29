# The Multi-Language Automatic Translation, Subtitling, and Voice Rendering System

![LanguageSystemIndex](https://user-images.githubusercontent.com/10620802/83774609-d2718800-a67d-11ea-9f3d-625b5c70cc60.jpg)

![LanguageSystemMedia](https://user-images.githubusercontent.com/10620802/83776248-dc948600-a67f-11ea-835a-cc4bb10c1362.jpg)

A system that uses third party software to automatically convert audio to text, translate text, render text to video, and render text to audio.

**Requirements**

- [Linux](https://www.linux.org/)
- [Apache HTTP Server](https://httpd.apache.org/)
- [PHP](https://php.net/)
- [MySQL Server](https://www.mysql.com/)
- [FFmpeg](https://ffmpeg.org/)
- [pipx](https://pipx.pypa.io/)
- [Autosub](https://github.com/agermanidis/autosub)
- [eSpeak](http://espeak.sourceforge.net/)
- [Composer](https://getcomposer.org/)
- [Google Translate PHP](https://github.com/Stichoza/google-translate-php)
- [Plupload](https://www.plupload.com/)
- [JustWave](https://github.com/beotiger/justwave)
- A World Wide Web browser

**Requirements for Optional Elements**

- [macOS](https://www.apple.com/macos/)
- [AWS SDK for PHP](https://aws.amazon.com/sdk-for-php/)
- An [Amazon Web Services](https://aws.amazon.com/) account

**Functions**

1. Transcribe a subtitle file from a video or audio file in around seventy languages. Currently it supports MP3, MP4, MPG, MXF, MOV, AIFF, and WAV files.
2. Translate subtitle files from one language to another in around seventy languages.
3. Machine speech rendering to video or audio with pronunciation dictionaries for around fifty languages.
4. Subtitle rendering to video with support for about twenty writing systems.
5. Run complex jobs that chain two or more tasks together.
6. Allows the user to upload subtitle files in the SRT format for use with the system.
7. Convert a subtitle file in the SRT format to a plain text file.

**Installation and Set Up**

1. Install [Linux](https://www.linux.org/).

2. Install [Apache HTTP Server](https://httpd.apache.org/).

3. Install [PHP](https://php.net/).

4. Install [MySQL Server](https://www.mysql.com/).

5. Install [FFmpeg](https://ffmpeg.org/).

6. Install [pipx](https://pipx.pypa.io/).

7. Install [Autosub](https://github.com/agermanidis/autosub).
  - Run `python3 -m venv /opt/venv`
  - Run `/opt/venv/bin/pip install git+https://github.com/agermanidis/autosub.git`

8. Install [eSpeak](http://espeak.sourceforge.net/).

9. Install [Composer](https://getcomposer.org/download/).

10. Install [Google Translate PHP](https://github.com/Stichoza/google-translate-php).

11. Install [Plupload](https://www.plupload.com/).

12. Install [JustWave](https://github.com/beotiger/justwave).
  - Run `cd /opt` then `git clone https://github.com/beotiger/justwave.git`

13. Clone the Git repository of Language System to a folder that is served by Apache HTTP Server.

14. Create a MySQL user for Language System to use.

15. Create a MySQL schema called 'language_system' and give the user you just made full access to it.

16. Install the database SQL files from the database folder.

17. Set the following environment variables to be read by Apache HTTP Server. On openSUSE the file to do this in is /usr/lib/systemd/system/apache2.service in the Service block.
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

18. Make sure all the folders you just told the system to use with environment variables exist and are readable and writeable by the user Apache HTTP Server runs as.

19. Make sure the following lines are in your PHP configuration file. A sample PHP configuration file is included at setup/php.ini
    ```
    post_max_size = 3500M
    max_execution_time = 300
    max_input_time = 300
    memory_limit = 512M
    file_uploads = On
    upload_max_filesize = 35000M
    ```

20. Start or restart Apache HTTP Server so it can load the environment variables.

**Installation and Set Up of Amazon Transcribe Integration (Optional)**

1. Install [AWS SDK for PHP](https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/getting-started_installation.html).

2. On the machine that Apache HTTP Server is running on, create a text file at /.aws/credentials

3. In /.aws/credentials enter the following: -
    ```
    [default]
    aws_access_key_id = YOURACCESSKEYGOESHERE
    aws_secret_access_key = YOURSECRETACCESSKEYGOESHERE
    region=eu-west-1
    ```

    Where YOURACCESSKEYGOESHERE is your AWS access key, YOURSECRETACCESSKEYGOESHERE is your AWS secret access key, and eu-west-1 is the AWS region you want to do your processing in.

4. Save the file and make sure it is readable by the user Apache HTTP Server runs as.

Your Language System installation should now be able to access Amazon Transcribe. The system has a quota to avoid excessive cost. By default, it is set to two million seconds. If you want to change this setting, access your database, go to the settings table and change the value of number in row one to your desired number of seconds.

**Installation and Set Up of macOS Speech Rendering (Optional)**

For this you will need a machine running macOS.

1. Open System Preferences.

2. Open Dictation & Speech.

3. Click on Text to Speech.

4. Click on the System Voice menu and select Customize.

5. Install one or more of the following voices: Kate, Serena, Daniel, Fiona, Moira, Veena, Karen, Tessa, Allison, Ava, Samantha, Susan, Ting-Ting, Sin-ja, Mei-Jia, Audrey, Aurelie, Markus, Petra, Yannick, Lekha, Kyoko, Otoya, Katya, Milena, Jorge, and Monica.

6. Make sure your Language System working folder is shared with the machine running macOS.

7. Create folders called 'speech_in', 'speech_out', and 'speech_settings' in your Language System working folder. Make sure the new folders are readable and writeable by the user Apache HTTP Server runs as and are accessible on the machine running macOS.

8. On the machine running macOS, copy Render_Speech_from_Text.scpt from the macOS folder to /Library/Scripts/Folder Action Scripts

9. Open Render_Speech_from_Text.scpt

10. Where you see /Path/ replace that with the path to the working folder and save the file.

11. Go to Finder. Open the working folder.

12. Right click on speech_in, select Services, and click on Folder Actions Setup.

13. Select Render_Speech_from_Text.scpt from the menu and click on Attach.

**Accessing the System**

Open a World Wide Web browser. Type a URL suitable to access your Language System installation.

If you installed Language System on your workstation in a folder called ls below the document root of Apache HTTP Server then the correct URL would be http://localhost/ls/

If you installed Language System on a machine with the domain name machine.domain.org in the document root of Apache HTTP Server then the correct URL would be http://machine.domain.org/

Access the URL. You should be prompted for a user name and password. Enter the default user name 'guest' and the default password 'language' and click on Submit.

At this point you should see the Language System main index page.

**Uploading a Media File**

Click on Select files. Choose a suitable media file to add to the system. MP3, MP4, MPG, MXF, MOV, AIFF, and WAV files are supported. Click on Upload files. After the percentage display next to the file name reads 100% you can reload the page. You should see a link to your file as text and a thumbnail graphic.

**Accessing a Media File**

Go to the Language System main index page. You should see links to up to sixteen media files that are in the system. If the media file you want to access it not linked on the first page, click on Next > until you see a link to that file. When a link to the media file you want to access it on screen click on it. At this point your browser should load a media page for your file.

**Transcribing Subtitles**

Go to the media page for the file you want to process. Find the Machine Transcription section. Select the language that the file contains. Click on Transcribe. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to an SRT file under the heading Subtitles.

**Transcribing Subtitles with Amazon Transcribe**

Go to the media page for the file you want to process. Find the Machine Transcription (Amazon) section. Select the language that the file contains. Click on Transcribe. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to an SRT file under the heading Subtitles.

**Translating Subtitles**

Go to the media page for the file you want to process subtitles for. Find the Machine Translation section. Select the subtitle file you want to process from the menu. From the Source menu, select the language that the subtitle file contains. From the Target menu, select the language you want the subtitles translated into. Click on Translate. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to a new SRT file under the heading Subtitles. The file will have an abbreviation for the name of the language it was translated into at the start of the file name.

**Rendering Speech to an Audio File**

Go to the media page for the file you want to process. Find the Machine Speech section. Select the subtitle file you want to use from the menu. From the Language menu, select the language that the subtitle file contains. Click on Render to Audio. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to a new Wave file under the heading Renders.

**Rendering Speech to a Video File**

Go to the media page for the file you want to process. Find the Machine Speech section. Select the subtitle file you want to use from the menu. From the Language menu, select the language that the subtitle file contains. Click on Render to Video. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to a new video file under the heading Renders.

**Rendering Speech to an Audio File with macOS**

Go to the media page for the file you want to process. Find the Machine Speech (Mac OS) section. Select the subtitle file you want to use from the menu. From the Voice menu, select a suitable voice for the language that the subtitle file contains. Click on Render to Audio. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to a new AIFF file under the heading Renders.

**Rendering Speech to a Video File with macOS**

Go to the media page for the file you want to process. Find the Machine Speech (Mac OS) section. Select the subtitle file you want to use from the menu. From the Voice menu, select a suitable voice for the language that the subtitle file contains. Click on Render to Video. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to a new video file under the heading Renders.

**Rendering Subtitles to a Video File**

Go to the media page for the file you want to render subtitles for. Find the Subtitle Rendering section. Select the subtitle file you want to use from the menu. Click on Render. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to a new video file under the heading Renders.

**Running a Complex Job**

Go to the media page for the file you want to run a complex job for. Find the Complex Jobs section. Select the job you want to run from the menu. If the job requires a subtitle file to work on, select a file from the subtitles menu. Click on Run. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again.

**Uploading a Subtitle File**

Go to the media page for the file you want to upload subtitles for. Find the Subtitle Upload section. Click on Browse. Choose a subtitle file in the SRT format. Click on Upload Subtitles. After the page reloads, you should see a link to a new SRT file under the heading Subtitles.

**Converting a Subtile File to a Text File**

Go to the media page for the file you want to process subtitles for. Find the Subtitles section. Find the subtitle file you want to convert in the list and click on the Convert to text link which is on the same line as it. At this point you should get forwarded to a job information page which tells you about the job you have just started. When the job finishes, the media page should display again. If the job was successful you should see a link to a new text file under the heading Text Files.

**The Job List Page**

The job list page shows information about jobs that have been started on the system. To get to it click on Jobs link which can be found at the top of the main index page and media pages. The job information is organized in a table with the following headings: -

Id.: The identification number of the job.

Name: The name of the job.

Type: The type of the job.

User: The user who started the job.

Start (UNIX): The UNIX time in seconds that the job was started on.

End (UNIX): If the job has finished, the UNIX time in seconds that the job ended on.

Start (Human Friendly): The time and date that the job was started on displayed in a more easily readable format.

End (Human Friendly): If the job has finished, the time and date that the job ended on displayed in a more easily readable format.

Status: The current status of the job.

Input 1-8: Strings that where sent to the job code.

Output 1-8: Strings that the job outputted.
