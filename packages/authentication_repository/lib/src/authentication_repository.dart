import 'dart:async';

/// Représente les différents types d'états d'authentification possible
enum AuthenticationStatus { unknown, authenticated, unauthenticated }

///Utilise un stream pour gérer l'authentification des utilisateurs
class AuthenticationRepository {
  final _controller = StreamController<AuthenticationStatus>();

  /// Getter qui expose le Stream de [AuthenticationRepository]
  /// Le stream notifie des changement de l'état d'authentification de l'utilisateur
  Stream<AuthenticationStatus> get status async* {
    await Future<void>.delayed(const Duration(seconds: 1));
    yield AuthenticationStatus.unauthenticated;
    yield* _controller.stream;
  }

  /// Methode permettant de simuler la connection de l'utilisateur
  Future<void> logIn({
    required String username,
    required String password,
  }) async {
    await Future.delayed(
      const Duration(milliseconds: 300),
      () => _controller.add(AuthenticationStatus.authenticated),
    );
  }

  /// Déconnecte l'utilisateur, change l'état de [AuthenticationStatus] a [AuthenticationStatus.unauthenticated]
  void logOut() {
    _controller.add(AuthenticationStatus.unauthenticated);
  }

  /// Ferme le [_controller] lorsqu'il n'est plus nécessaire pour libérer des ressources
  void dispose() => _controller.close();
}
