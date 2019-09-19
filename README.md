# md_php

Markdownによる記事作成
------------

Markdownを使用してページを出力するプログラムmd.phpについて説明いたします。

### Markdownとは

マークダウンは、簡単な規則によりテキストを書くことで、見栄えの良いページを出力するための方法の一つです。<br>
GitHub（開発者に人気のあるソフトウェア公開サイト）の説明ページを記述するのに使用されています。

[Markdown(ウィキペディア)](<https://ja.wikipedia.org/wiki/Markdown>)


### 使用しているツール、CSS

次のツールとCSSを使用しました。

*	・PHP Markdown Lib 1.8.0 - 14 Jan 2018<br>
by Michel Fortin<br>
<a href="https://michelf.ca/">https://michelf.ca/</a>

*	・generate-github-markdown-css<br>
by Sindre Sorhus<br>
<a href="https://github.com/sindresorhus/generate-github-markdown-css">https://github.com/sindresorhus/generate-github-markdown-css</a>

PHPのプログラムを作成しました。
このプログラムは、PHP Markdown Libを使用して、指定されたMarkdownファイルの内容をHTMLに変換して、ベースとなるHTMLファイルの本文部分へ出力します。<br>

### 準備

PHP Markdown Libとgenerate-github-markdown-cssが必要です。
それぞれダウンロードして、md.phpと同じディレクトリに置いて起きます。

<p>
・PHP Markdown Lib 1.8.0 - 14 Jan 2018<br>
by Michel Fortin<br>
<a href="https://michelf.ca/">https://michelf.ca/</a><br>
</p>
<p>
・generate-github-markdown-css<br>
by Sindre Sorhus<br>
<a href="https://github.com/sindresorhus/generate-github-markdown-css">https://github.com/sindresorhus/generate-github-markdown-css</a>
</p>

自分のサーバー環境に合わせて、.htaccessを編集して設置します。
多くのレンタルサーバーの場合は、オリジナルのままで良いと思います。

### 出力する方法

一般的なレンタルサーバーでは、マークダウンファイルを直接扱えるようにはなっていません。
今回使用したものは、PHPで作成されているので、PHPが使えるレンタルサーバーであれば使用することができます。

マークダウンファイルを表示するには、出力するマークダウンファイルをPHPのプログラムに渡す必要があります。
一番簡単なのは、URLに直接PHPプログラムとマークダウンファイルを指定する方法です。

```
http://crytus.info/md.php?f=readme.md
```

もう少しスマートにしたかったので、WEBサーバーの設定を変えてマークダウンファイルを直接指定する方法を取りました。
使用しているサーバーはApache系のWEBサーバーなので、.htaccessが使えますので、この設定で対応しました。（サーバーによっては管理ツールからの設定など、方法が異なりますので、ご利用のサーバーに合わせた方法にする必要があります。）

いくつか方法があるのですが、ローカルの開発環境では、次の方法が使えました。

```
AddType text/markdown md
Action text/markdown /md.php
```

拡張子がmdの場合にmd.phpを起動するという指定です。

使用しているレンタルサーバーでは、この方法が使えなかったので、次のようにしています。

```
RewriteEngine on
RewriteRule ^(.+\.md)$ /md.php?f=$1 [L]
```

WEBサイト関連の仕事をしている人にはおなじみのRewriteです。
この場合は、拡張子部分がmdのURLを指定されると、最初に示したURLに自動的に書き換えてくれます。

どちらの方法でも、次のようなURLでマークダウンファイルを表示することができます。

```
http://crytus.info/readme.md
```

### md.phpの機能

このPHPプログラムは、指定されたマークダウンファイルを読み込んで、HTMLへ変換して出力します。<br>
その際に、いくつか工夫をしています。

<dl style="margin-left:30px">
  <dt>HTMLファイルの指定</dt>
  <dd>マークダウン出録を行うベースとなるHTMLファイルの指定を可能としました。<br>これにより、ページごとに別のHTMLを使用することが可能になります。</dd>
  <dt>ページタイトルやキーワード、ヘッダーなどの指定</dt>
  <dd>ページごとにタイトルなどを変えられるように、マークダウンファイルの先頭に特定の記述をすると、その内容が反映されます。<br>現在は、タイトル、キーワード、ディスクリプションを指定できるようにしています。</dd>
</dl>
