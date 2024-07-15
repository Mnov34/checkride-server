part of 'login_bloc.dart';

/// Contient le [status] actuel du formulaire, ainsi que le status de [Username] et [Password]
final class LoginState extends Equatable {
  const LoginState({
    this.status = FormzSubmissionStatus.initial,
    this.username = const Username.pure(),
    this.password = const Password.pure(),
    this.isValid = false,
  });

  final FormzSubmissionStatus status;
  final Username username;
  final Password password;
  final bool isValid;

  /// Créer une copie de l'instance actuelle de [LoginState] avec la possibilité
  /// de modifier certaines de ses propriétés
  LoginState copyWith({
    FormzSubmissionStatus? status,
    Username? username,
    Password? password,
    bool? isValid,
  }) {
    return LoginState(
      status: status ?? this.status,
      username: username ?? this.username,
      password: password ?? this.password,
      isValid: isValid ?? this.isValid,
    );
  }

  /// Comparaison Equatable
  @override
  List<Object> get props => [status, username, password];
}
