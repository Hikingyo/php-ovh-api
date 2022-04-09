# CONTRIBUTION GUIDELINES

Contributions are **welcome** and will be fully **credited**.

We accept contributions via pull requests on GitHub. Please review these guidelines before continuing.

## Guidelines

* Please follow the [PSR-12 Coding Style Guide](https://www.php-fig.org/psr/psr-12/), enforced by [StyleCI](https://styleci.io/).
* Ensure that the current tests pass, and if you've added something new, add the tests where relevant.
* Send a coherent commit history, making sure each commit in your pull request is meaningful.
* You may need to [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing) to avoid merge conflicts.
* If you are changing or adding to the behaviour or public API, you may need to update the docs.
* Please remember that we follow [Semantic Versioning](https://semver.org/).

## Running Tests

First, install the dependencies:

```bash
$ make install
```

Then run the test suite:

```bash
$ make test
```

## Before you submit a pull request

You should make sure that your pull request passes all the tests and analysis.

You can run all with:

```bash
make cd
```

You can also add it to your `.git/hooks/pre-push` file:

```bash
#!/bin/bash

make cd
if [ $? -ne 0 ]; then
    echo ""
    echo ""
    echo "CHECKSTYLE FAILED:"
    echo "You can fix them automatically by running male"
    echo "or fix each point as describe."
    echo ""
    exit 1
fi

exit 0
```

* The tests will be automatically run by [GitHub Actions](https://github.com/features/actions) against pull requests.
* Style are enforced by [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
* Static analysis are enforced by [PHPStan](https://github.com/phpstan/phpstan)
* Automation is enforced by [Rector](https://github.com/rectorphp/rector)
