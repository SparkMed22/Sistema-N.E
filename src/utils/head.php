<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title; ?></title>

    <meta name="description" content="Sistema de Nutrición Enteral del Hospital General de Itapúa">

    <link rel="icon" href="/assets/img/logo2.png">

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    

    <script id="tailwind-config">
        tailwind.config = {

            darkMode: "class",

            theme: {

                extend: {

                    colors: {

                        "on-primary": "rgb(var(--on-primary) / <alpha-value>)",

                        "surface-container": "rgb(var(--surface-container) / <alpha-value>)",

                        "primary-fixed-dim": "rgb(var(--primary-fixed-dim) / <alpha-value>)",

                        "outline": "rgb(var(--outline) / <alpha-value>)",

                        "on-background": "rgb(var(--on-background) / <alpha-value>)",

                        "surface": "rgb(var(--surface) / <alpha-value>)",

                        "outline-variant": "rgb(var(--outline-variant) / <alpha-value>)",

                        "error": "rgb(var(--error) / <alpha-value>)",

                        "surface-container-highest": "rgb(var(--surface-container-highest) / <alpha-value>)",

                        "primary": "rgb(var(--primary) / <alpha-value>)",

                        "surface-container-lowest": "rgb(var(--surface-container-lowest) / <alpha-value>)",

                        "on-tertiary-fixed": "rgb(var(--on-tertiary-fixed) / <alpha-value>)",

                        "on-primary-fixed": "rgb(var(--on-primary-fixed) / <alpha-value>)",

                        "secondary-fixed-dim": "rgb(var(--secondary-fixed-dim) / <alpha-value>)",

                        "surface-container-high": "rgb(var(--surface-container-high) / <alpha-value>)",

                        "background": "rgb(var(--background) / <alpha-value>)",

                        "tertiary-fixed-dim": "rgb(var(--tertiary-fixed-dim) / <alpha-value>)",

                        "on-surface": "rgb(var(--on-surface) / <alpha-value>)",

                        "tertiary-container": "rgb(var(--tertiary-container) / <alpha-value>)",

                        "surface-container-low": "rgb(var(--surface-container-low) / <alpha-value>)",

                        "on-tertiary-fixed-variant": "rgb(var(--on-tertiary-fixed-variant) / <alpha-value>)",

                        "on-secondary-fixed": "rgb(var(--on-secondary-fixed) / <alpha-value>)",

                        "tertiary": "rgb(var(--tertiary) / <alpha-value>)",

                        "on-error-container": "rgb(var(--on-error-container) / <alpha-value>)",

                        "inverse-surface": "rgb(var(--inverse-surface) / <alpha-value>)",

                        "primary-container": "rgb(var(--primary-container) / <alpha-value>)",

                        "on-tertiary": "rgb(var(--on-tertiary) / <alpha-value>)",

                        "secondary-container": "rgb(var(--secondary-container) / <alpha-value>)",

                        "on-tertiary-container": "rgb(var(--on-tertiary-container) / <alpha-value>)",

                        "inverse-on-surface": "rgb(var(--inverse-on-surface) / <alpha-value>)",

                        "secondary": "rgb(var(--secondary) / <alpha-value>)",

                        "primary-fixed": "rgb(var(--primary-fixed) / <alpha-value>)",

                        "tertiary-fixed": "rgb(var(--tertiary-fixed) / <alpha-value>)",

                        "surface-bright": "rgb(var(--surface-bright) / <alpha-value>)",

                        "on-secondary-fixed-variant": "rgb(var(--on-secondary-fixed-variant) / <alpha-value>)",

                        "error-container": "rgb(var(--error-container) / <alpha-value>)",

                        "on-primary-fixed-variant": "rgb(var(--on-primary-fixed-variant) / <alpha-value>)",

                        "on-secondary-container": "rgb(var(--on-secondary-container) / <alpha-value>)",

                        "on-surface-variant": "rgb(var(--on-surface-variant) / <alpha-value>)",

                        "secondary-fixed": "rgb(var(--secondary-fixed) / <alpha-value>)",

                        "surface-variant": "rgb(var(--surface-variant) / <alpha-value>)",

                        "surface-tint": "rgb(var(--surface-tint) / <alpha-value>)",

                        "on-secondary": "rgb(var(--on-secondary) / <alpha-value>)",

                        "surface-dim": "rgb(var(--surface-dim) / <alpha-value>)",

                        "on-primary-container": "rgb(var(--on-primary-container) / <alpha-value>)",

                        "inverse-primary": "rgb(var(--inverse-primary) / <alpha-value>)",

                        "on-error": "rgb(var(--on-error) / <alpha-value>)"

                    },

                    borderRadius: {

                        DEFAULT: "0.25rem",

                        lg: "0.5rem",

                        xl: "0.75rem",

                        "2xl": "1.5rem",

                        full: "9999px"

                    },

                    spacing: {

                        gutter: "1.5rem",

                        "stack-md": "1rem",

                        "container-padding": "2.5rem",

                        "stack-sm": "0.5rem",

                        "stack-lg": "2rem"

                    },

                    fontFamily: {

                        sans: ["Manrope", "sans-serif"]

                    }

                }

            }

        };
    </script>

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        [popover]::backdrop {
            background-color: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-popover {
            border: none;
            background: transparent;
            padding: 1rem;
            margin: auto;
            opacity: 0;
        }

        .modal-popover:popover-open {
            opacity: 1;
        }
    </style>

</head>