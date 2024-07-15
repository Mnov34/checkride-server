part of 'login_bloc.dart';

/// S'occupe des events du bloc login ([LoginBloc])
sealed class LoginEvent extends Equatable {
  const LoginEvent();

  @override
  List<Object> get props => [];
}

/// Notifie le bloc que le champ de [Username] a changé
final class LoginUsernameChanged extends LoginEvent {
  const LoginUsernameChanged(this.username);

  final String username;

  @override
  List<Object> get props => [username];
}

/// Notifie le bloc que le champ de [Password] a changé
final class LoginPasswordChanged extends LoginEvent {
  const LoginPasswordChanged(this.password);

  final String password;

  @override
  List<Object> get props => [password];
}

/// Notifie le bloc que le formulaire a été envoyé
final class LoginSubmitted extends LoginEvent {
  const LoginSubmitted();
}
