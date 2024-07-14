import 'package:checkride_mobile/login/bloc/login_bloc.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:formz/formz.dart';

class LoginForm extends StatelessWidget {
  const LoginForm({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocListener<LoginBloc, LoginState>(
      listener: (context, state) {
        if (state.status.isFailure) {
          ScaffoldMessenger.of(context)
            ..hideCurrentSnackBar()
            ..showSnackBar(
              const SnackBar(content: Text('Authentication failed')),
            );
        }
      },
      child: Stack(fit: StackFit.expand, children: [
        Image.asset(
          'assets/images/background.jpg',
          fit: BoxFit.cover,
          alignment: Alignment.centerRight,
        ),
        Center(
          child: Container(
            padding: const EdgeInsets.all(16.0),
            width: MediaQuery.of(context).size.width * 0.85,
            height: MediaQuery.of(context).size.height * 0.5,
            decoration: BoxDecoration(
              color: const Color.fromRGBO(19, 43, 64, 1),
              borderRadius: BorderRadius.circular(20),
            ),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: <Widget>[
                _UsernameInput(),
                const SizedBox(height: 9.0),
                _PasswordInput(),
                const SizedBox(height: 10.0),
                _LoginButton(),
                const SizedBox(height: 13.0),
                Row(mainAxisAlignment: MainAxisAlignment.center, children: [
                  _ForgotPasswordButton(),
                  const SizedBox(width: 30),
                  _SignUpButton(),
                ]),
              ],
            ),
          ),
        )
      ]),
    );
  }
}

class _UsernameInput extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(
      buildWhen: (previous, current) => previous.username != current.username,
      builder: (context, state) {
        return FractionallySizedBox(
          widthFactor: 0.7,
          child: Column(children: [
            const Align(
              alignment: Alignment.centerLeft,
              child: Text('Identifiant',
                  style: TextStyle(color: Colors.white, fontSize: 16)),
            ),
            TextField(
              key: const Key('loginForm_usernameInput_textField'),
              onChanged: (username) =>
                  context.read<LoginBloc>().add(LoginUsernameChanged(username)),
              decoration: InputDecoration(
                fillColor: Colors.white,
                filled: true,
                border: const OutlineInputBorder(
                  borderRadius: BorderRadius.zero,
                ),
                errorText: state.username.displayError != null
                    ? 'Invalid username'
                    : null,
              ),
            )
          ]),
        );
      },
    );
  }
}

class _PasswordInput extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(
        buildWhen: (previous, current) => previous.password != current.password,
        builder: (context, state) {
          return FractionallySizedBox(
            widthFactor: 0.7,
            child: Column(children: [
              const Align(
                alignment: Alignment.centerLeft,
                child: Text('Mot de passe',
                    style: TextStyle(color: Colors.white, fontSize: 16)),
              ),
              TextField(
                key: const Key('loginForm_passwordInput_textField'),
                obscureText: true,
                onChanged: (password) => context
                    .read<LoginBloc>()
                    .add(LoginPasswordChanged(password)),
                decoration: InputDecoration(
                  fillColor: Colors.white,
                  filled: true,
                  border: const OutlineInputBorder(
                    borderRadius: BorderRadius.zero,
                  ),
                  errorText: state.password.displayError != null
                      ? 'Invalid password'
                      : null,
                ),
              )
            ]),
          );
        });
  }
}

class _LoginButton extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(
      builder: (context, state) {
        final buttonStyle = ElevatedButton.styleFrom(
          backgroundColor: const Color.fromRGBO(59, 126, 201, 1),
          foregroundColor: const Color.fromRGBO(255, 255, 255, 1),
          padding: const EdgeInsets.symmetric(horizontal: 80.0, vertical: 12.0),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(15),
          ),
          textStyle: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
        );
        return state.status.isInProgressOrSuccess
            ? const CircularProgressIndicator()
            : ElevatedButton(
                key: const Key('loginForm_continue_raisedButton'),
                onPressed: state.isValid
                    ? () {
                        context.read<LoginBloc>().add(const LoginSubmitted());
                      }
                    : null,
                style: !state.status.isInProgressOrSuccess
                    ? buttonStyle
                    : ElevatedButton.styleFrom(
                        backgroundColor: Colors.red,
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(
                            horizontal: 80.0, vertical: 12.0),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(15),
                        ),
                        textStyle: const TextStyle(
                            fontSize: 16, fontWeight: FontWeight.bold),
                      ),
                child: const Text('CONNEXION'),
              );
      },
    );
  }
}

class _ForgotPasswordButton extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(
      builder: (context, state) {
        return TextButton(
          key: const Key('loginForm_forgotPassword_raisedButton'),
          onPressed: () {
            //Navigator.of(context).pushNamed('/forgot_password');
          },
          child: const Text(
            'Mot de passe oublié',
            style: TextStyle(color: Colors.white),
          ),
        );
      },
    );
  }
}

class _SignUpButton extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return TextButton(
      key: const Key('loginForm_signUp_flatButton'),
      onPressed: () {
        //Navigator.of(context).pushNamed('/sign_up');
      },
      child: const Text(
        'Inscription',
        style: TextStyle(color: Colors.white),
      ),
    );
  }
}
