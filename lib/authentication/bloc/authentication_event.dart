part of 'authentication_bloc.dart';

/// Utilisé comme input pour [AuthenticationBloc]
/// puis est traité et utilisé pour [emit] des nouvelles instances de [AuthenticationState]
sealed class AuthenticationEvent {
  const AuthenticationEvent();
}

/// Notifie le bloc ([AuthenticationBloc]) d'un changement de l'était de [AuthenticationStatus]
final class _AuthenticationStatusChanged extends AuthenticationEvent {
  const _AuthenticationStatusChanged(this.status);

  final AuthenticationStatus status;
}

/// Notifie le bloc d'une requête de déconnexion
final class AuthenticationLogoutRequested extends AuthenticationEvent {}