<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Bued AI Installer') }}</title>
    <link rel="stylesheet" href="{{ asset('installer/css/style.min.css') }}">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .installer-shell {
            max-width: 980px;
            margin: 40px auto;
            padding: 0 20px 40px;
        }

        .installer-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .installer-header {
            padding: 28px 32px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .installer-header h1 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .installer-header p {
            margin: 0;
            color: #6b7280;
            line-height: 1.6;
        }

        .installer-body {
            padding: 24px 32px 32px;
        }

        .alert {
            margin-bottom: 24px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fed7aa;
        }

        .errors {
            margin: 0 0 24px;
            padding: 14px 16px 14px 32px;
            border-radius: 12px;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .section-title {
            margin: 28px 0 14px;
            font-size: 18px;
            font-weight: 700;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .field label {
            font-size: 14px;
            font-weight: 700;
        }

        .field input,
        .field select {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            background: #fff;
        }

        .field small {
            color: #6b7280;
            line-height: 1.5;
        }

        .actions {
            margin-top: 28px;
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 10px;
            padding: 13px 18px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .button-primary {
            background: #111827;
            color: #fff;
        }

        .button-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .installer-shell {
                margin-top: 20px;
                padding: 0 12px 24px;
            }

            .installer-header,
            .installer-body {
                padding-left: 18px;
                padding-right: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="installer-shell">
        <div class="installer-card">
            <div class="installer-header">
                <h1>{{ __('Bued AI Installer') }}</h1>
                <p>{{ __('This screen prepares the application environment file, then runs the built-in installation flow on the server.') }}</p>
            </div>

            <div class="installer-body">
                <div class="alert">
                    {{ __('This installer uses the project local installation flow. License checks are disabled in this build.') }}
                </div>

                @if ($errors->any())
                    <ul class="errors">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('installer.envEditor.save') }}">
                    @csrf

                    <div class="section-title">{{ __('Application') }}</div>
                    <div class="grid">
                        <div class="field">
                            <label for="app_name">{{ __('Application Name') }}</label>
                            <input id="app_name" name="app_name" type="text" value="{{ old('app_name', 'Bued AI') }}" required>
                        </div>

                        <div class="field">
                            <label for="app_url">{{ __('Application URL') }}</label>
                            <input id="app_url" name="app_url" type="url" value="{{ old('app_url', url('/')) }}" required>
                        </div>

                        <div class="field">
                            <label for="environment">{{ __('Environment') }}</label>
                            <select id="environment" name="environment" required>
                                @foreach (['production', 'staging', 'local'] as $environment)
                                    <option value="{{ $environment }}" @selected(old('environment', 'production') === $environment)>{{ strtoupper($environment) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="app_debug">{{ __('Debug Mode') }}</label>
                            <select id="app_debug" name="app_debug" required>
                                <option value="false" @selected(old('app_debug', 'false') === 'false')>{{ __('Disabled') }}</option>
                                <option value="true" @selected(old('app_debug') === 'true')>{{ __('Enabled') }}</option>
                            </select>
                            <small>{{ __('Keep this disabled on the live server.') }}</small>
                        </div>
                    </div>

                    <div class="section-title">{{ __('Database') }}</div>
                    <div class="grid">
                        <div class="field">
                            <label for="database_hostname">{{ __('Database Host') }}</label>
                            <input id="database_hostname" name="database_hostname" type="text" value="{{ old('database_hostname', 'localhost') }}" required>
                        </div>

                        <div class="field">
                            <label for="database_name">{{ __('Database Name') }}</label>
                            <input id="database_name" name="database_name" type="text" value="{{ old('database_name') }}" required>
                        </div>

                        <div class="field">
                            <label for="database_username">{{ __('Database Username') }}</label>
                            <input id="database_username" name="database_username" type="text" value="{{ old('database_username') }}" required>
                        </div>

                        <div class="field">
                            <label for="database_password">{{ __('Database Password') }}</label>
                            <input id="database_password" name="database_password" type="password" value="{{ old('database_password') }}">
                        </div>
                    </div>

                    <div class="section-title">{{ __('Mail') }}</div>
                    <div class="grid">
                        <div class="field">
                            <label for="mail_mailer">{{ __('Mailer') }}</label>
                            <select id="mail_mailer" name="mail_mailer" required>
                                @foreach (['smtp', 'sendmail', 'log'] as $mailer)
                                    <option value="{{ $mailer }}" @selected(old('mail_mailer', 'smtp') === $mailer)>{{ strtoupper($mailer) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="mail_host">{{ __('Mail Host') }}</label>
                            <input id="mail_host" name="mail_host" type="text" value="{{ old('mail_host', 'localhost') }}">
                        </div>

                        <div class="field">
                            <label for="mail_port">{{ __('Mail Port') }}</label>
                            <input id="mail_port" name="mail_port" type="text" value="{{ old('mail_port', '465') }}">
                        </div>

                        <div class="field">
                            <label for="mail_encryption">{{ __('Encryption') }}</label>
                            <select id="mail_encryption" name="mail_encryption">
                                <option value="" @selected(old('mail_encryption', 'ssl') === '')>{{ __('None') }}</option>
                                <option value="ssl" @selected(old('mail_encryption', 'ssl') === 'ssl')>SSL</option>
                                <option value="tls" @selected(old('mail_encryption') === 'tls')>TLS</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="mail_username">{{ __('Mail Username') }}</label>
                            <input id="mail_username" name="mail_username" type="text" value="{{ old('mail_username') }}">
                        </div>

                        <div class="field">
                            <label for="mail_password">{{ __('Mail Password') }}</label>
                            <input id="mail_password" name="mail_password" type="password" value="{{ old('mail_password') }}">
                        </div>

                        <div class="field">
                            <label for="mail_from_address">{{ __('From Address') }}</label>
                            <input id="mail_from_address" name="mail_from_address" type="email" value="{{ old('mail_from_address', 'support@bued-ai.com') }}">
                        </div>

                        <div class="field">
                            <label for="mail_from_name">{{ __('From Name') }}</label>
                            <input id="mail_from_name" name="mail_from_name" type="text" value="{{ old('mail_from_name', old('app_name', 'Bued AI')) }}">
                        </div>
                    </div>

                    <div class="actions">
                        <button type="submit" class="button button-primary">{{ __('Save Environment And Continue') }}</button>
                        <a href="{{ route('installer.install') }}" class="button button-secondary">{{ __('Run Installer Now') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
