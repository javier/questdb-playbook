# questdb-playbook

This repository contains the source of "The QuestDB Playbook: Patterns and Snippets for Time-Series Practitioners" book.

The most recent version of this book can be found [in this same repository][mostRecentPDF].

If you prefer to read the book locally, please keep reading.

[mostRecentPdf]: ./book/pandoc/pdf/The-QuestDB-Playbook.pdf

## Requirements

Building the book requires to [install Rust] and [mdBook].

[install Rust]: https://www.rust-lang.org/tools/install
[mdBook]: https://github.com/rust-lang/mdBook


```bash
cargo install mdbook
```

## Reading a local version of the book

From the root directory of this repository, run:

```bash
mdbook serve --port 3000 --open
```

## Exporting the book as a static website


From the root directory of this repository, run:

```
mdbook build
```

The output will be in the `book` subdirectory. Please note if you
uncomment the PDF output, as seen below, the static site will be
instead at `book/html`.

To open it in your web browser.

_Firefox:_
```bash
$ firefox book/index.html                       # Linux
$ open -a "Firefox" book/index.html             # OS X
$ Start-Process "firefox.exe" .\book\index.html # Windows (PowerShell)
$ start firefox.exe .\book\index.html           # Windows (Cmd)
```

_Chrome:_
```bash
$ google-chrome book/index.html                 # Linux
$ open -a "Google Chrome" book/index.html       # OS X
$ Start-Process "chrome.exe" .\book\index.html  # Windows (PowerShell)
$ start chrome.exe .\book\index.html            # Windows (Cmd)
```

## Exporting the book as a PDF

Export is done via the `mdbook-pandoc` plugin. You need to install it
with

```bash
cargo install mdbook-pandoc
```

You also need to install `Pandoc` and `LaTeX`. You don't need a full distribution
of LaTeX. For example, Mac users can install `MacTeX` via package or homebrew
and it will suffice.

Once you have yout dependencies installed, you need to uncomment the
block `[output.pandoc.profile.pdf]` at the `book.toml` file. Then build as
usual with:

```
mdbook build
```

The output folder will now contain two subfolders, one for html, one for `pandoc`
output. The pdf will be available at `book/pandoc/pdf/The-QuestDB-Playbook.pdf`

## Removing the locally generated files

If you want to delete the output directory, you can execute:

```
mdbook clean
```

## License

`The QuestDB Playbook: Patterns and Snippets for Time-Series Practitioners` is licensed under the Apache License, Version 2.0, ([LICENSE-APACHE](LICENSE-APACHE)
  <http://www.apache.org/licenses/LICENSE-2.0>)

