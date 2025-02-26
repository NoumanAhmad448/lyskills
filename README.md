<h3 align="center">
Lyskills
</h3>
<p align="center">
    A platform for learning and practicing skills
</p>

<div align="center">

<a href="https://github.com/NoumanAhmad448/lyskills/stargazers">
    <img src="https://img.shields.io/github/stars/hiyouga/LLaMA-Factory?style=social" alt="GitHub Repo stars"/>
</a>
<a href="https://github.com/NoumanAhmad448/lyskills/commits/master">
    <img src="https://img.shields.io/github/last-commit/NoumanAhmad448/lyskills" alt="GitHub last commit"/>
</a>
<a href="https://github.com/NoumanAhmad448/lyskills/graphs/contributors">
    <img src="https://img.shields.io/github/contributors/hiyouga/LLaMA-Factory?color=orange" alt="GitHub contributors"/>
</a>
<a href="https://github.com/NoumanAhmad448/lyskills/pulls">
    <img src="https://img.shields.io/badge/PRs-welcome-blue" alt="GitHub pull request"/>
</a>
</div>

A **Video-Based Learning Management System (LMS)** is a specialized platform designed to deliver, manage, and track educational courses and training programs primarily through video content. It is widely used in online education, corporate training, and skill development to provide an engaging and flexible learning experience.



#### **Core Features of a Video-Based LMS:**

1. **Video Content Management**:

    - Upload, organize, and stream video lectures, tutorials, and demonstrations.
    - Support for multiple video formats (e.g., MP4, WebM, MOV).
    - Adaptive streaming for smooth playback across devices.

2. **Course Creation and Management**:

    - Create structured courses with video modules, quizzes, and assignments.
    - Add supplementary materials like PDFs, slides, and external links.
    - Set prerequisites and completion rules for course progression.

3. **Interactive Learning Tools**:

    - **Quizzes and Assessments**: Embed quizzes within or after videos to test knowledge.
    - **Annotations and Comments**: Allow learners to add timestamped comments or questions.
    - **Polls and Surveys**: Engage learners with interactive polls during video playback.

4. **Progress Tracking and Analytics**:

    - Track learner progress through video courses (e.g., % watched, quiz scores).
    - Monitor engagement metrics like video completion rates and drop-off points.
    - Generate detailed reports for instructors and administrators.

5. **Accessibility and Inclusivity**:

    - Add subtitles, closed captions, and transcripts for better accessibility.
    - Support multiple languages for global audiences.
    - Ensure responsive design for seamless viewing on mobile, tablet, and desktop.

6. **Collaboration and Communication**:

    - **Live Sessions**: Host live webinars or virtual classrooms with real-time interaction.
    - **Discussion Forums**: Enable learners to discuss course topics and share insights.
    - **Chat and Messaging**: Facilitate communication between learners and instructors.

7. **Gamification and Engagement**:

    - Award badges, certificates, or points for completing courses or achieving milestones.
    - Leaderboards to encourage healthy competition among learners.

8. **Integration and Scalability**:
    - Integrate with third-party services (e.g., payment gateways, social media platforms).
    - Support for large-scale deployments with high availability and scalability.

## Development

1. Turn on xampp
2. PHP server

```
php artisan serve --port=8080
```

3. Turn on npm server

```
npm run watch
```

## Development Guildlines

1. Add all global setting constants in `custom_lib .blade.php`
2. custom javascript functions in `common_functions.js`
3. show loader on user request `profile.js` and search for `hide loader` & `show loader`
4. server logs `server_logs` function in `helper.php`
5. server configuration `php_config` function in `helper.php`

```
8. Checkout storage on server
```

df -hi

```
9. cloudflare setup for extra security
[Todo list after registeration](./cloudflare.todo.md)

## Local Setup (Development)
1. install xampp (Required PHP version -> 8.1) [Download Link](https://downloadsapachefriends.global.ssl.fastly.net/7.4.30/xampp-windows-x64-7.4.30-1-VC15-installer.exe?from_af=true)
2. download node 16.18.0
2. Copy
```

.env.dev

```
to
```

.env

````
file and change the DB connection

1. Create a database <b>db</b>
2. You need to follow of either mentioned path
    1. One
        1. run
            1. db.sql
            2. <b>user_ann_models.sql</b>
               file locally. These files are avaiable in the source code, path /
        2. Add primary key manually in every table or create a alter query and try changing table name and primary key column
    2. Second
        1. php artisan migrate
        2. Get dump from someone else and upload
3. Visit ```storage/framework``` folder and create
````

views

```
folder
4. Run
```

composer install

```
5. Run
```

npm install

```
6. Finally😍😍😍 Run
```

php artisan serve --port=8081

```


# Server Configurations
nano /var/log/nginx/test-django.error.log debug;
nano  /var/log/nginx/test-django.access.log

nano /etc/uwsgi/test_django.log
nano /etc/uwsgi/sites/test_django.ini
systemctl status uwsgi.service
systemctl restart uwsgi

netstat -na|grep LISTEN |grep :81
cd /run/uwsgi

public_html/test-django.lyskills.com/

nano /etc/systemd/system/uwsgi.service
nano  /etc/nginx/nginx.conf
