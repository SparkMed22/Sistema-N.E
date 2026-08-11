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



    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>


    <script id="tailwind-config">
        tailwind.config = {

            darkMode: "class",

            theme: {

                extend: {

                    colors: {

                        "on-primary": "#ffffff",
                        "surface-container": "#e8eaf6",
                        "primary-fixed-dim": "#a5b4fc",
                        "outline": "#6366f1",
                        "on-background": "#0f172a",
                        "surface": "#f8fafc",
                        "outline-variant": "#c7d2fe",
                        "error": "#e11d48",
                        "surface-container-highest": "#e0e7ff",
                        "primary": "#312e81",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed": "#1e1b4b",
                        "on-primary-fixed": "#0f172a",
                        "secondary-fixed-dim": "#818cf8",
                        "surface-container-high": "#eef2ff",
                        "background": "#f8fafc",
                        "tertiary-fixed-dim": "#c7d2fe",
                        "on-surface": "#0f172a",
                        "tertiary-container": "#4338ca",
                        "surface-container-low": "#f1f5f9",
                        "on-tertiary-fixed-variant": "#312e81",
                        "on-secondary-fixed": "#1e1b4b",
                        "tertiary": "#3730a3",
                        "on-error-container": "#881337",
                        "inverse-surface": "#1e293b",
                        "primary-container": "#3730a3",
                        "on-tertiary": "#ffffff",
                        "secondary-container": "#818cf8",
                        "on-tertiary-container": "#e0e7ff",
                        "inverse-on-surface": "#f1f5f9",
                        "secondary": "#4f46e5",
                        "primary-fixed": "#e0e7ff",
                        "tertiary-fixed": "#e0e7ff",
                        "surface-bright": "#f8fafc",
                        "on-secondary-fixed-variant": "#3730a3",
                        "error-container": "#ffe4e6",
                        "on-primary-fixed-variant": "#312e81",
                        "on-secondary-container": "#1e1b4b",
                        "on-surface-variant": "#475569",
                        "secondary-fixed": "#e0e7ff",
                        "surface-variant": "#e2e8f0",
                        "surface-tint": "#4338ca",
                        "on-secondary": "#ffffff",
                        "surface-dim": "#cbd5e1",
                        "on-primary-container": "#c7d2fe",
                        "inverse-primary": "#a5b4fc",
                        "on-error": "#ffffff"
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