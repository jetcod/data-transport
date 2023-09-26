# Configuration file for the Sphinx documentation builder.
#
# For the full list of built-in configuration values, see the documentation:
# https://www.sphinx-doc.org/en/master/usage/configuration.html

# -- Project information -----------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#project-information

project = 'PHP Data Transport'
copyright = '2023, Jetcod'
author = 'Hamid Ghorashi'

# -- General configuration ---------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#general-configuration

extensions = ['sphinxcontrib.googleanalytics']

googleanalytics_id = 'G-LSZ44QC1Z5'

templates_path = ['_templates']
exclude_patterns = []

html_copy_source = False

# -- Options for HTML output -------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#options-for-html-output

html_theme = 'sphinx_material'
html_static_path = ['_static']

html_sidebars = {
    "**": ["globaltoc.html", "localtoc.html", "searchbox.html"]
}

# Material theme options (see theme.conf for more information)
html_theme_options = {

    # Set the name of the project to appear in the navigation.
    'nav_title': 'PHP Data Transport',

    # Set you GA account ID to enable tracking
    # 'google_analytics_account': 'UA-XXXXX',

    # Specify a base_url used to generate sitemap.xml. If not
    # specified, then no sitemap will be built.
    'base_url': 'https://jetcod.github.io/data-transport',

    # Set the color and the accent color
    'color_primary': 'blue',
    'color_accent': 'light-blue',

    # Set the repo location to get a badge with stats
    'repo_url': 'https://github.com/jetcod/data-transport/',
    'repo_name': 'jetcod/data-transport',

    'html_minify': True,
    'css_minify': True,
    'logo_icon': '&#xe869',

    'repo_type': 'github',

    # Visible levels of the global TOC; -1 means unlimited
    'globaltoc_depth': 3,
    # If False, expand all TOC entries
    'globaltoc_collapse': True,
    # If True, show hidden TOC entries
    'globaltoc_includehidden': False,

}
