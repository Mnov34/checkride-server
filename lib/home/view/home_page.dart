import 'package:checkride_mobile/authentication/bloc/authentication_bloc.dart';
import 'package:checkride_mobile/home/bloc/home_bloc.dart';
import 'package:checkride_mobile/home/view/view.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:http/http.dart' as http;

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const HomePage());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: BlocProvider(
        create: (_) => HomeBloc(httpClient: http.Client())..add(BikeFetched()),
        child: Center(
          child: Stack(fit: StackFit.expand, children: [
            Image.asset(
              'assets/images/background.jpg',
              fit: BoxFit.cover,
              alignment: Alignment.centerRight,
            ),
            Center(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: <Widget>[
                  Row(mainAxisAlignment: MainAxisAlignment.center, children: [
                    Builder(builder: (context) {
                      final userId = context.select(
                        (AuthenticationBloc bloc) => bloc.state.user.id,
                      );
                      return Text(
                        'User ID: $userId',
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 9,
                        ),
                      );
                    }),
                    ElevatedButton(
                      onPressed: () {
                        context
                            .read<AuthenticationBloc>()
                            .add(AuthenticationLogoutRequested());
                      },
                      child: const Text('Logout'),
                    ),
                  ]),
                  _SearchInput(),
                  const HomeList(),
                ],
              ),
            )
          ]),
        ),
      ),
    );
  }
}

class _SearchInput extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<HomeBloc, HomeState>(
        buildWhen: (previous, current) => current.search != previous.search,
        builder: (context, state) {
          return TextField(
            key: const Key('searchForm_searchInput_textField'),
            onChanged: (search) =>
                context.read<HomeBloc>().add(SearchBikeRequested(search)),
            decoration: const InputDecoration(
              hintText: 'Search for bikes',
              border: OutlineInputBorder(
                borderRadius: BorderRadius.zero,
              ),
              fillColor: Colors.white,
              filled: true,
            ),
          );
        });
  }
}
