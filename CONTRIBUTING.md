# Contributing to juit/phpspec-multi-formatter

> **NOTE:** Currently we are not accepting code contributions to this project because it is in a very early stage.

First we want to thank you considering contributing to this project. We really appreciate it!

Next we would like to outline a small set of guidelines for contributions.

#### Table of Contents

[Code of Conduct](#code-of-conduct)

[I don't want to read the whole thing I just have a question!!!](#i-dont-want-to-read-the-whole-thing-i-just-have-a-question)

[What should I know before I get started?](#what-should-i-know-before-i-get-started)

[How can I contribute?](#how-can-i-contribute)
* [Reporting Bugs](#reporting-bugs)
* [Suggesting Enhancements](#suggesting-enhancements)
* [Your first code contribution](#your-first-code-contribution)
* [Pull Requests](#pull-requests)

[Styleguides](#styleguides)

## Code of Conduct

This project and everyone participating in it is governed by out Code of Conduct. By participating,
you are expected to uphold this code. Please report unacceptable behavior to [info@juit.de](mailto:info@juit.de).

## I don't want to read the whole thing I just have a question!!!

We are giving support only via Gitlab. So you are very welcome to open an issue clearly stating the question
in the summary. Please give additional information in the issue description and add the label `question`.

## What should I know before I get started?

You should have a basic understanding of [phpspec](https://www.phpspec.net) and how to build extensions for it.
Additionally understanding of SOLID principles and clean code are helpful but not necessarily required. We'll help you
out there.

We require a simple code-style though. You can run `tools/php-cs-fixer fix` to check and fix your changes before
pushing.

## How can I contribute?

### Reporting Bugs

This section guides you through submitting a bug report for this project. Following these guidelines helps maintainers
and the community understand your report :pencil:, reproduce the behavior :computer: :computer:, and find related
reports :mag_right:.

Before creating bug reports, please check the existing issues as you might find out that you don't need to create one.
When you are creating a bug report, please [include as many details as possible](#how-do-i-submit-a-good-bug-report).
Fill out the required template if there is one, the information it asks for helps us resolve issues faster.

> **Note:** If you find a **Closed** issue that seems like it is the same thing that you're experiencing, open a new
> issue and include a link to the original issue in the body of your new one.

#### How Do I Submit A (Good) Bug Report?

Bugs are tracked as issues. Create an issue and provide the following information.

Explain the problem and include additional details to help maintainers reproduce the problem:

* **Use a clear and descriptive title** for the issue to identify the problem.
* **Describe the exact steps which reproduce the problem** in as many details as possible. When listing steps,
  **don't just say what you did, but explain how you did it**.
* **Provide specific examples to demonstrate the steps**. If you're providing snippets in the issue, use
  Markdown code blocks.
* **Describe the behavior you observed after following the steps** and point out what exactly is the problem with that
  behavior.
* **Explain which behavior you expected to see instead and why.**

Provide more context by answering these questions:

* **Did the problem start happening recently** (e.g. after updating to a new version of this project) or was this
  always a problem?
* If the problem started happening recently, **can you reproduce the problem in an older version?** What's the most
  recent version in which the problem doesn't happen?
* **Can you reliably reproduce the issue?** If not, provide details about how often the problem happens and under which
  conditions it normally happens.

Include details about your configuration and environment:

* **Which version of this project are you using?**
* **Which version of PHP are you using?**

### Suggesting Enhancements

This section guides you through submitting an enhancement suggestion for this project, including completely new features
and minor improvements to existing functionality. Following these guidelines helps maintainers and the community
understand your suggestion :pencil: and find related suggestions :mag_right:.

Before creating enhancement suggestions, please check the existing issues as you might find out that you don't need to
create one. When you are creating an enhancement suggestion, please [include as many details as possible](#how-do-i-submit-a-good-enhancement-suggestion).

#### How do I submit a (GOOD) enhancement suggestion?

Enhancement suggestions are tracked as issues. Create an issue on that repository and provide the following information:

* **Use a clear and descriptive title** for the issue to identify the suggestion.
* **Provide a step-by-step description of the suggested enhancement** in as many details as possible.
* **Provide specific examples to demonstrate the steps**. Include copy/pasteable snippets which you use in those
  examples, as Markdown code blocks.
* **Describe the current behavior** and **explain which behavior you expected to see instead** and why.
* **Explain why this enhancement would be useful**.

### Your first code contribution

We will provide detailed information how to create and contribute code changes once we are ready.

### Pull Requests

We will provide detailed information how to create and contribute code changes once we are ready.

## Styleguides

We utilize php-cs-fixer to maintain a basic code style. You can run it with `tools/php-cs-fixer fix`.

We utilize psalm to maintain proper type definitions. You can run it with `tools/psalm`.

